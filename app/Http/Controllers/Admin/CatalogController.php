<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Category;
use App\Rules\Isbn13Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CatalogController extends Controller
{
    /*
     * Mostra i libri
     * e filtra i risultati
     */
    public function create(Request $request)
    {
        $query = Book::createQuery($request);

        $available = $request->input('available');
        if ($available == 'true') {
            $query->has('copies');
        }

        return Inertia::render('dashboard/Catalog', [
            'categories' => Category::all(),
            'filters' => [
                'available' => $available,
                'search' => $request->input('search'),
                'category' => $request->input('category'),
                'year' => $request->input('year'),
            ],
            'books' => BookResource::collection(
                $query->with('category')->latest()->paginate(15)->withQueryString()
            ),
        ]);
    }

    /*
     * Aggiorna libro
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'description' => 'required|string',
            'isbn' => ['required', 'string', Rule::unique('books', 'isbn')->ignore($id), new Isbn13Rule()],
            'year' => 'required|integer',
            'category' => 'present|nullable|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'tags' => 'present|nullable|string'
        ]);

        $book = Book::with('category')->findOrFail($id);
        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->publisher = $validated['publisher'];
        $book->year = $validated['year'];
        $book->description = $validated['description'];
        $book->ISBN = $validated['isbn'];
        $book->category_id = $validated['category'];
        $book->tags = $validated['tags'];

        if ($request->hasFile('cover')) {
            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }
            $book->cover = $request->file('cover')->store('books', 'public');
        }

        $book->save();

        return redirect()->route('catalogo');
    }

    /*
     * Crea libro
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $book = new Book();

        $book->title = $validated['title'];
        $book->author = $validated['author'];
        $book->publisher = $validated['publisher'];
        $book->description = $validated['description'];
        $book->ISBN = $validated['isbn'];
        $book->year = $validated['year'];
        $book->category_id = $validated['category'];
        $book->tags = $validated['tags'];

        if ($request->hasFile('cover')) {
            $book->cover = $request->file('cover')->store('books', 'public');
        }

        $book->save();
        return redirect()->back();
    }

    /*
     * Elimina libro
     * ed eventuali copie
     * e prenotazioni
     */
    public function delete($id)
    {
        $book = Book::findOrFail($id);

        if (Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }

        foreach ($book->copies as $copy) {
            $copy->bookings()->delete();
        }

        $book->copies()->delete();
        $book->delete();

        return redirect()->back();
    }
}
