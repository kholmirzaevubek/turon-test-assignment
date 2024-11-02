<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Movies\ListMoviesDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Movies\ListMoviesFormRequest;
use App\Services\Dashboard\MovieService;
use Illuminate\Contracts\View\View;
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
}
