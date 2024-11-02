<?php

namespace App\DTOs\Dashboard\Genres;

use App\Http\Requests\Dashboard\Genres\ListGenreFormRequest;

final class ListGenreDTO
{
    public function __construct(
        public readonly ?string $name,
    ){
    }

    public static function fromRequest(ListGenreFormRequest $request): self
    {
        return new self (
            name: $request->input('name'),
        );
    }
}
