<?php

namespace App\Services;

use App\DTOs\ListMoviesDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\Genre;
use App\Models\Movie;

final class MovieService
{

    private const DEFAULT_PAGINATION_LIMIT = 15;

    public function __construct(
        private readonly ResponseService $responseService
    ){
    }

    public function listMovies(ListMoviesDTO $dto): ServiceResponseDTO
    {
        $query = Movie::query();

        if ($dto->title !== null) {
            $query->where('title', 'like', '%' . $dto->title . '%');
        }

        if ($dto->genre_id !== 0) {
            $query->where('genre_id', '=', $dto->genre_id);
        }

        $movies = $query->paginate(self::DEFAULT_PAGINATION_LIMIT);

        $genres = Genre::all();
        return $this->responseService->successResponse(data: [
            'movies' => $movies,
            'genres' => $genres
        ]);
    }

    public function getSpecificMovie(int $movie_id): ServiceResponseDTO
    {
        $movie = Movie::with('genre')->find($movie_id);

        if (! $movie) {
            return $this->responseService->failureResponse(message: 'movie not found');
        }

        return $this->responseService->successResponse(data: [
            'movie' => $movie
        ]);
    }
}
