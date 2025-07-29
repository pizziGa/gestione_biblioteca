<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Booking;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /*
     * Mostra il catalogo al cliente
     * e filtra i risultati
     */
    public function create(Request $request)
    {
        $query = Book::createQuery($request);

        // se è spuntata la casella mostra anche i libri non disponibili (senza copie)
        $unavailable = $request->input('unavailable');
        if ($unavailable == 'false' || $unavailable == '') {
            $query->has('copies');
        }

        return Inertia::render('app/Catalog', [
            'books' => BookResource::collection(
                $query->with(['category'])->paginate(7)->withQueryString()
            ),
            'filters' => [
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'year' => $request->input('year'),
                'unavailable' => $unavailable,
            ],
            'categories' => Category::all()
        ]);
    }

    /*
     * Mostra le prenotazioni del cliente
     */
    public function myBookings()
    {
        return Inertia::render('app/BookingPage', [
            'bookings' => Booking::with(['copy.book'])->where('user_id', auth()->user()->id)->get()
        ]);
    }

    /*
     * Mostra la scheda del libro selezionato
     * e le copie prenotabili
     *
     * Ordina le copie consigliando quello
     * più conveniente da prenotare
     */
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        $copies = $book->copies()->withCount(['bookings as active_bookings_count' => function ($query) {
            $query->whereNotNull('queue');
        }])
        ->orderBy('active_bookings_count')
        ->orderByRaw('FIELD(conditions, "Ottimo", "Buono", "Discreto")')
        ->get();

        $bookedCopies = Booking::where('user_id', auth()->user()->id)->pluck('copy_id')->toArray();

        return Inertia::render('app/Book', [
            'book' => $book,
            'copies' => $copies,
            'booked_copies' => $bookedCopies, // usate per confrontare e disabilitare le copie già prenotate
        ]);
    }
}
