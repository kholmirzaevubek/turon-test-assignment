<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Movies\UpdateMovieDTO;
use App\DTOs\Dashboard\Movies\CreateMovieDTO;
use App\DTOs\Dashboard\Movies\ListMoviesDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Movies\CreateMovieFormRequest;
use App\Http\Requests\Dashboard\Movies\ListMoviesFormRequest;
use App\Http\Requests\Dashboard\Movies\UpdateMovieFormRequest;
use App\Services\Dashboard\MovieService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function __construct(
        private readonly MovieService $movieService
    ){
    }

    public function listMovies(ListMoviesFormRequest $request): View
    {
        $serviceResponse = $this->movieService->listMovies(ListMoviesDTO::fromRequest($request));

        return view('dashboard.movies.listmovies', $serviceResponse->data);
    }

    public function showCreateFormMovie(): View
    {
        $serviceResponse = $this->movieService->showCreateFormMovie();

        return view('dashboard.movies.createmovie', $serviceResponse->data);
    }

    public function createMovie(CreateMovieFormRequest $request): RedirectResponse
    {
        $serviceResponse = $this->movieService->createMovie(CreateMovieDTO::fromRequest($request));

        return redirect()->route('dashboard.movies.list-movies')->with($serviceResponse->data);
    }

    public function showUpdateFormMovie(Request $request): View
    {
        $serviceResponse = $this->movieService->showUpdateFormMovie(intval($request->route('movieId')));

        if ($serviceResponse->error) {
            return redirect()->route('dashboard.movies.list-movies')->withErrors(['message' => $serviceResponse->message]);
        }
        return view('dashboard.movies.updatemovie', $serviceResponse->data);
    }

    public function updateMovie(UpdateMovieFormRequest $request): RedirectResponse
    {
        $serviceResponse = $this->movieService->updateMovie(UpdateMovieDTO::fromRequest($request), intval($request->route('movieId')));

        if ($serviceResponse->error) {
            return redirect()->route('dashboard.movies.show-update-movie')->withErrors(['message' => $serviceResponse->message]);
        }

        return redirect()->route('dashboard.movies.list-movies')->with($serviceResponse->data);
    }
}
