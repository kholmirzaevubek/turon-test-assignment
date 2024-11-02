<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Genres\CreateGenreDTO;
use App\DTOs\Dashboard\Genres\ListGenreDTO;
use App\DTOs\Dashboard\Genres\UpdateGenreDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGenreFormRequest;
use App\Http\Requests\Dashboard\Genre\UpdateGenreFormRequest;
use App\Http\Requests\Dashboard\Genres\ListGenreFormRequest;
use App\Services\Dashboard\GenreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function __construct(
        private readonly GenreService $genreService
    ){
    }

    public function listGenres(ListGenreFormRequest $request): View
    {
        $serviceResponse = $this->genreService->listGenre(ListGenreDTO::fromRequest($request));

        return view('dashboard.genres.listgenres', $serviceResponse->data);
    }

    public function showCreateGenre(): View
    {
        return view('dashboard.genres.creategenre');
    }

    public function createGenre(CreateGenreFormRequest $request): RedirectResponse
    {
        $serviceResponse = $this->genreService->createGenre(CreateGenreDTO::fromRequest($request));

        return redirect()->route('dashboard.genres.list-genres', $serviceResponse->data);
    }

    public function showUpdateGenre(Request $request)
    {
        $serviceResponse = $this->genreService->showUpdateGenre(intval($request->route('genreId')));

        if ($serviceResponse->error) {
            return redirect()->route('dashboard.genres.list-genres')->withErrors(['message' => $serviceResponse->message]);
        }

        return view('dashboard.genres.updategenre', $serviceResponse->data);
    }

    public function updateGenre(UpdateGenreFormRequest $request): RedirectResponse
    {
        $serviceResponse = $this->genreService->updateGenre(UpdateGenreDTO::fromRequest($request), intval($request->route('genreId')));

        if ($serviceResponse->error) {
            return redirect()->route('dashboard.genres.list-genres')->withErrors(['message' => $serviceResponse->message]);
        }

        return redirect()->route('dashboard.genres.list-genres', $serviceResponse->data);
    }

    public function deleteGenre(Request $request)
    {
        $serviceResponse = $this->genreService->deleteGenre(intval($request->route('genreId')));

        if ($serviceResponse->error) {
            return redirect()->route('dashboard.genres.list-genres')->withErrors(['message' => $serviceResponse->message]);
        }

        return redirect()->route('dashboard.genres.list-genres', $serviceResponse->data);
    }
}
