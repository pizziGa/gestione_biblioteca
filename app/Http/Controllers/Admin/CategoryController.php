<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CategoryController extends Controller
{

    /*
     * Mostra le categorie
     */
    public function create(Request $request)
    {
        $query = Category::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%");
        }

        return Inertia::render('dashboard/Categories', [
            'categories' => CategoryResource::collection(
                $query->paginate(10)->withQueryString()
            )
        ]);
    }

    /*
     * Crea nuove categorie
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
        ]);

        $category = new Category();

        $category->name = $validated['name'];
        $category->save();
        return Redirect::route('categorie');
    }

    /*
     * Aggiorna il nome di una categoria
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);

        $category->name = $validated['name'];
        $category->save();
        return Redirect::route('categorie');
    }

    /*
     * Elimina categoria
     */
    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $books = $category->books();
        foreach ($books as $book) {
            $book->category_id = 0;
        }

        $category->delete();
        return Redirect::route('categorie');
    }
}
