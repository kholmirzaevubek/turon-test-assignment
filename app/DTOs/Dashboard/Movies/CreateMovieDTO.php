<?php
namespace App\DTOs\Dashboard\Movies;

use Carbon\Carbon;
use App\Http\Requests\Dashboard\Movies\CreateMovieFormRequest;
use Illuminate\Http\UploadedFile;

final class CreateMovieDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $genre_id,
        public readonly Carbon $released_date,
        public readonly ?string $trailer_link,
        public readonly UploadedFile $upload_file
    ){
    }

    public static function fromRequest(CreateMovieFormRequest $request): self
    {
        return new self (
            title: $request->input('title'),
            description: $request->input('description'),
            genre_id: $request->input('genre_id'),
            released_date: Carbon::parse($request->input('released_date')),
            trailer_link: $request->input('trailer_link'),
            upload_file: $request->file('upload_file')
        );
    }
}
