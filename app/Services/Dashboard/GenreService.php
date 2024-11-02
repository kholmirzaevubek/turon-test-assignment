<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Genres\CreateGenreDTO;
use App\DTOs\Dashboard\Genres\ListGenreDTO;
use App\DTOs\Dashboard\Genres\UpdateGenreDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\Genre;
use App\Services\ResponseService;

final class GenreService
{

    private const DEFAULT_PAGINE_LIMIT = 15;

    public function __construct(
        private readonly ResponseService $responseService
    ){
    }

    private function getUserId(): int
    {
        $userId = auth()->check() ? auth()->user()->id : null;

        return $userId;
    }


    public function listGenre(ListGenreDTO $dto): ServiceResponseDTO
    {
        $query = Genre::query();

        if ($dto->name !== null) {
            $query->where('name', 'like', '%' . $dto->name . '%');
        }

        $genres = $query->paginate(self::DEFAULT_PAGINE_LIMIT);

        return $this->responseService->successResponse(data: [
            'genres' => $genres
        ]);
    }

    public function createGenre(CreateGenreDTO $dto): ServiceResponseDTO
    {
        $genre = new Genre();
        $genre->user_id = $this->getUserId();
        $genre->name = $dto->name;
        $genre->save();

        return $this->responseService->successResponse(data: [
            'message' => "create $genre->name"
        ]);
    }

    public function showUpdateGenre(int $genre_id): ServiceResponseDTO
    {
        $genre = Genre::find($genre_id);

        if (! $genre) {
            return $this->responseService->failureResponse(message: 'genre not found');
        }

        return $this->responseService->successResponse(data: [
            'genre' => $genre
        ]);
    }

    public function updateGenre(UpdateGenreDTO $dto, int $genre_id): ServiceResponseDTO
    {
        $genre = Genre::find($genre_id);

        if (! $genre) {
            return $this->responseService->failureResponse(message: 'genre not found');
        }
        $genre->name = $dto->name;
        $genre->save();

        return $this->responseService->successResponse(data: [
            'message' => "update $genre->name",
        ]);
    }

    public function deleteGenre(int $genre_id): ServiceResponseDTO
    {
        $genre = Genre::find($genre_id);

        if (! $genre) {
            return $this->responseService->failureResponse(message: 'genre not found');
        }
        $genre_name = $genre->name;
        $genre->delete();

        return $this->responseService->successResponse(data: [
            'message' => "deleted $genre_name"
        ]);
    }
}
