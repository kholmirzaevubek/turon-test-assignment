<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Movies\CreateMovieDTO;
use App\DTOs\Dashboard\Movies\ListMoviesDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Movies\CreateMovieFormRequest;
use App\Http\Requests\Dashboard\Movies\ListMoviesFormRequest;
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
}
