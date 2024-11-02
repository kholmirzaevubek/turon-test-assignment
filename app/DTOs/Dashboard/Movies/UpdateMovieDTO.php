<?php

namespace App\DTOs\Dashboard\Movies;

use App\Http\Requests\Dashboard\Movies\UpdateMovieFormRequest;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

final class UpdateMovieDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly Carbon $released_date,
        public readonly ?string $trailer_link,
        public readonly ?UploadedFile $file,
        public readonly ?int $genre_id
    ){
    }

    public static function fromRequest(UpdateMovieFormRequest $request): self
    {
        return new self (
            title: $request->input('title'),
            description: $request->input('description'),
            file: $request->file('file'),
            released_date: Carbon::parse($request->input('released_date')),
            trailer_link: $request->input('trailer_link'),
            genre_id: $request->input('genre_id')
        );
    }
}
