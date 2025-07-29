<?php

namespace App\Http\Requests;

use App\Rules\Isbn13Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'description' => 'required|string',
            'isbn' => ['required', 'string', 'unique:books,isbn', new Isbn13Rule()],
            'year' => 'required|integer',
            'category' => 'present|nullable|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,svg',
            'tags' => 'present|nullable|string'
        ];
    }
}
