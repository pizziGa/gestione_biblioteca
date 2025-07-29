<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Copy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BookingController extends Controller
{
    /*
     * Mostra le prenotazioni
     * effettuate dai clienti
     */
    public function create(Request $request)
    {
        $query = Booking::query()
            ->with(['user:id,name', 'copy.book'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($subquery) use ($search) {
                    $subquery
                        ->whereHas('user', fn($q) => $q->where('name', 'like', "%$search%"))
                        ->orWhereHas('copy', fn($q) => $q->where('barcode', 'like', "%$search%"))
                        ->orWhereHas('copy.book', fn($q) => $q->where('title', 'like', "%$search%"));
                });
            });

        return Inertia::render('dashboard/Booking', [
            'bookings' => BookingResource::collection(
                $query->paginate(10)->withQueryString()
            ),
            'filters' => $request->only('search')
        ]);
    }

    /*
     * Crea una nuova prenotazione e aggiorna la coda
     * se ci sono già presenti altre prenotazione
     * per la stessa copia
     */
    public function store(Request $request)
    {
        $copy = Copy::find($request->input('copy'));
        $position = (Booking::where('copy_id', $copy->id)->max('queue') ?? 0) + 1;

        Booking::create([
            'user_id' => $request->user()->id,
            'copy_id' => $request->input('copy'),
            'queue' => $position,
        ]);

        $copy->status = 'Prenotato';

        $copy->save();

        return Redirect::route('customer.prenotazioni');
    }

    /*
     * Elimina la prenotazione da parte del cliente o admin
     * Controlla se ci sono altri clienti in coda e aggiorna le posizioni
     * Se non ci sono più prenotazioni, aggiorna lo stato della copia a disponibile
     */
    public function delete($id)
    {
        $oldBooking = Booking::findOrFail($id);
        $copy = Copy::findOrFail($oldBooking->copy_id);

        Booking::where('copy_id', $oldBooking->copy_id)
            ->where('queue', '>', $oldBooking->queue)
            ->orderBy('queue')
            ->get()
            ->each(fn($booking) => $booking->decrement('queue'));

        $oldBooking->delete();

        $next = Booking::where('copy_id', $copy->id)->orderBy('queue')->first();

        if (!$next) {
            $copy->status = 'Disponibile';
            $copy->save();
        }

        return Redirect::back();
    }
}
