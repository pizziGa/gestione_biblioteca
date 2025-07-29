<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCopyRequest;
use App\Http\Resources\CopyResource;
use App\Models\Book;
use App\Models\Copy;
use Inertia\Inertia;

class CopyController extends Controller
{
    /*
     * Mostra le copie fisiche di un libro
     */
    public function create($id)
    {
        $book = Book::findOrFail($id);
        $copies = $book->copies()->paginate(5);
        return Inertia::render('dashboard/Copies', [
            'book_id' => $book->id,
            'copies' => CopyResource::collection(
                $copies
            )
        ]);
    }

    /*
     * Crea la copia
     */
    public function store(StoreCopyRequest $request, $id)
    {
        $validated = $request->validated();
        $book = Book::findOrFail($id);
        Copy::create([
            'barcode' => Copy::generateBarcode($book->ISBN),
            'conditions' => $validated['conditions'],
            'note' => $validated['note'],
            'book_id' => $id
        ]);

        return redirect()->back();
    }
}
