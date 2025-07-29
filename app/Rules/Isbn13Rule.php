<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Isbn13Rule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isbn = preg_replace('/[^0-9]/', '', $value);

        if (strlen($isbn) !== 13) {
            $fail('Deve essere di 13 cifre');
            return;
        }

        // Calcolo del check digit
        $sum = 0;
        for ($i = 0; $i < 12; $i++) {
            $digit = (int) $isbn[$i];
            $sum += ($i % 2 === 0) ? $digit : $digit * 3;
        }

        $checkDigit = (10 - ($sum % 10)) % 10;

        if ($checkDigit !== (int) $isbn[12]) {
            $fail('ISBN non valido');
        }
    }
}
