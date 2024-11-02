<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Movies\CreateMovieDTO;
use App\DTOs\Dashboard\Movies\ListMoviesDTO;
use App\DTOs\Dashboard\Movies\UpdateMovieDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\Genre;
use App\Models\Movie;
use App\Services\ResponseService;
use App\Services\UploadService;

final class MovieService
{
    private const DEFAULT_PAGINATION_LIMIT = 1;

    public function __construct(
        private readonly ResponseService $responseService,
        private readonly UploadService $uploadService
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
    private function getUserId(): int
    {
        $userId = auth()->check() ? auth()->user()->id : null;

        return $userId;
    }

    public function showCreateFormMovie(): ServiceResponseDTO
    {
        $genres = Genre::all();

        return $this->responseService->successResponse(data: ['genres' => $genres]);
    }

    public function createMovie(CreateMovieDTO $dto): ServiceResponseDTO
    {
        // Upload the file using the upload service and specify the directory for movies
        $upload_file = $this->uploadService->upload($dto->upload_file, 'movies');

        $movie = new Movie(); // Create a new instance of the Movie model
        $movie->user_id = $this->getUserId();
        $movie->title = $dto->title;
        $movie->description = $dto->description;

        $movie->released_date = $dto->released_date->format('Y-m-d'); // Set the released date of the movie, formatting it to 'Y-m-d'

        // Check if a trailer link is provided in the DTO
        if ($dto->trailer_link !== null) {
            // Convert the trailer link to an embed URL format and set it for the movie
            $movie->trailer_link = $this->convertToEmbedUrl($dto->trailer_link);
        }
        $movie->genre_id = $dto->genre_id;
        $movie->upload_file = $upload_file;
        $movie->save();

        // Return a successful response with a message indicating the movie has been created
        return $this->responseService->successResponse(data: [
            'message' => "create $movie->title"
        ]);
    }


    private function convertToEmbedUrl(string $url): string
    {
        // Replace 'watch?v=' with 'embed/' to convert the standard YouTube link to an embed link
        $url = str_replace('watch?v=', 'embed/', $url);

        // Replace 'youtu.be/' with 'www.youtube.com/embed/' for links shortened with youtu.be
        $url = str_replace('youtu.be/', 'www.youtube.com/embed/', $url);

        // Return the transformed URL, now in an embeddable format
        return $url;
    }

    public function showUpdateFormMovie(int $movie_id):ServiceResponseDTO
    {
        $movie = Movie::find($movie_id);

        $genres = Genre::all();

        if (! $movie) {
            return $this->responseService->failureResponse(message: 'movie not found');
        }

        return $this->responseService->successResponse(data: [
            'movie' => $movie,
            'genres' => $genres
        ]);
    }

    public function updateMovie(UpdateMovieDTO $dto, int $movie_id): ServiceResponseDTO
    {

        // Find the movie by its ID. This retrieves the existing movie from the database.
        $movie = Movie::find($movie_id);

        // Check if the movie was not found
        if (! $movie) {
            // Return a failed response if the movie does not exist
            return $this->responseService->failureResponse(message: 'movie not found');
        }

        $movie->title = $dto->title;
        $movie->description = $dto->description;
        $movie->released_date = $dto->released_date->format('Y-m-d');
        if ($dto->trailer_link !== null) {
            $movie->trailer_link = $this->convertToEmbedUrl($dto->trailer_link);
        }

        // Check if a new file is uploaded in the DTO
        if ($dto->file){
            // Upload the new file using the upload service and update the movie's upload path
            $uploadFile = $this->uploadService->upload($dto->file, 'movies');
            $movie->upload_file = $uploadFile;
        }
        $movie->genre_id = $dto->genre_id;
        $movie->save();

        return $this->responseService->successResponse(data: [
            'message' => "update $movie->title",
            'movie' => $movie
        ]);
    }

    public function deleteMovie(int $movie_id): ServiceResponseDTO
    {
        $movie = Movie::find($movie_id);

        if (! $movie) {
            return $this->responseService->failureResponse(message: 'movie not found');
        }
        $movie_title = $movie->title;

        $movie->delete();

        return $this->responseService->successResponse(data: [
            'message' => "deleted $movie_title"
        ]);
    }
}
