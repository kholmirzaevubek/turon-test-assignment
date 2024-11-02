<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Movies\ListMoviesDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\Genre;
use App\Models\Movie;
use App\Services\ResponseService;

final class MovieService
{
    private const DEFAULT_PAGINATION_LIMIT = 1;

    public function __construct(
        private readonly ResponseService $responseService
    ){
    }

    public function listMovies(ListMoviesDTO $dto): ServiceResponseDTO
    {
        $query = Movie::query(); // Prepare a query to fetch movies

        // If a title filter is provided, apply it to the query
        if ($dto->title !== null) {
            $query->where('title', 'like', '%' . $dto->title . '%');
        }

        // If a genre ID filter is provided, apply it to the query
        if ($dto->genre_id !== null) {
            $query->where('genre_id', '=', $dto->genre_id);
        }

        // Execute the query and paginate the results based on the default pagination limit
        $movies = $query->paginate(self::DEFAULT_PAGINATION_LIMIT);

         // Retrieve all genres from the database for display purposes
        $genres = Genre::all();

        // Return a successful response containing the paginated movies and all genres
        return $this->responseService->successResponse(data: [
            'movies' => $movies,
            'genres' => $genres
        ]);
    }
}
