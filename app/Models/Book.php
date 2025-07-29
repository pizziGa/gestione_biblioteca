<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Builder;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'ISBN',
        'description',
        'author',
        'publisher',
        'year',
        'cover',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function copies(): HasMany
    {
        return $this->hasMany(Copy::class);
    }

    /*
     * Crea la query per la ricerca
     * e il filtraggio
     */
    static public function createQuery(Request $request): Builder
    {
        $query = Book::query();

        // filtro della ricerca
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                    ->orWhere('author', 'like', "%$search%")
                    ->orWhere('publisher', 'like', "%$search%")
                    ->orWhere('ISBN', 'like', "%$search%")
                    ->orWhere('tags', 'like', "%$search%");
            });
        }

        // filtro della categoria
        if ($request->filled('category')) {
            $category = $request->input('category');
            $query->where('category_id', $category);
        }

        // filtro dell'anno
        if ($request->filled('year')) {
            $year = $request->input('year');
            $query->where('year', $year);
        }

        return $query;
    }
}
