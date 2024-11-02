<?php

namespace App\Http\Requests\Dashboard\Movies;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieFormRequest extends FormRequest
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
            'title' => ['string', 'max:255'],
            'description' => ['string'],
            'file' => ['file', 'mimes:png,jpg,jpeg', 'max:2048'],
            'released_date' => ['date'],
            'trailer_link' => ['nullable', 'url'],
            'genre_id' => ['integer', Rule::exists(Genre::class, 'id')]
        ];
    }
}
