<?php

namespace App\Http\Requests\Dashboard\Movies;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateMovieFormRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'released_date' => ['required', 'date'],
            'trailer_link' => ['nullable', 'url'],
            'genre_id' => [
                'required',
                'integer',
                Rule::exists(Genre::class, 'id')
            ],
            'upload_file' => ['required', 'file', 'mimes:png,jpg,jpeg', 'max:2048']
        ];
    }
}
