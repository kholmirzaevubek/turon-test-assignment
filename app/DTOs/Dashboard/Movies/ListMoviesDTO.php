<?php

namespace App\DTOs\Dashboard\Movies;

use App\Http\Requests\Dashboard\Movies\ListMoviesFormRequest;

final class ListMoviesDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?int $genre_id
    ){
    }

    public static function fromRequest(ListMoviesFormRequest $request): self
    {
        return new self (
            title: $request->input('title'),
            genre_id: $request->integer('genre_id'),
        );
    }
}
