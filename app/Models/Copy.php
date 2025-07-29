<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Copy extends Model
{
    protected $fillable = ['barcode', 'conditions', 'note', 'book_id'];

    public function book(): belongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function bookings(): hasMany
    {
        return $this->hasMany(Booking::class);
    }

    /*
     *  Genera il codice a barre
     *  di una copia fisica di un libro;
     *  Si basa sull'ISBN seguito da un suffisso randomico
     *  per garantire univocità e che sia facilmente
     *  riconducibile all'istanza digitale
     */
    static public function generateBarcode($isbn): string
    {
        return $isbn.'-'.Str::upper(Str::random(4));
    }
}
