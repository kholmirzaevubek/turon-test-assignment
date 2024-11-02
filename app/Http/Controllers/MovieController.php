<?php

namespace App\Http\Controllers;

use App\DTOs\ListMoviesDTO;
use App\Http\Requests\ListMoviesFormRequest;
use App\Services\MovieService;
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

        return view('listmovie', $serviceResponse->data);
    }

    public function getSpecificMovie(Request $request): View
    {
        $serviceResponse = $this->movieService->getSpecificMovie(intval($request->route('movieId')));

        if ($serviceResponse->error) {
            return redirect()->route('home')->withErrors(['message' => $serviceResponse->message]);
        }

        return view('specificmovie', $serviceResponse->data);
    }
}
