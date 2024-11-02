<?php

namespace App\DTOs\Dashboard\Genres;

use App\Http\Requests\CreateGenreFormRequest;

final class CreateGenreDTO
{
    public function __construct(
        public readonly string $name,
    ){
    }

    public static function fromRequest(CreateGenreFormRequest $request): self
    {
        return new self (
            name: $request->input('name'),
        );
    }
}
