<?php

namespace App\DTOs\Dashboard\Genres;

use App\Http\Requests\Dashboard\Genre\UpdateGenreFormRequest;

final class UpdateGenreDTO
{
    public function __construct(
        public readonly ?string $name,
    ){
    }

    public static function fromRequest(UpdateGenreFormRequest $request): self
    {
        return new self (
            name: $request->input('name'),
        );
    }
}
