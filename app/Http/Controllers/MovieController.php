<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Http\Requests\StoreMovieRequest;
use App\Repositories\MovieRepository;

class MovieController extends Controller
{
    protected $movieService;
    protected $movieRepo;

    public function __construct(MovieService $movieService, MovieRepository $movieRepo)
    {
        $this->movieService = $movieService;
        $this->movieRepo = $movieRepo;
    }

    public function store(StoreMovieRequest $request)
    {
        $this->movieService->storeMovie($request->validated(), $request->file('foto_sampul'));
        return redirect('/')->with('success', 'Berhasil disimpan');
    }

    public function update(StoreMovieRequest $request, $id)
    {
        $this->movieService->updateMovie($id, $request->validated(), $request->file('foto_sampul'));
        return redirect('/movies/data')->with('success', 'Berhasil diperbarui');
    }
    
    // Gunakan repository untuk index dan detail
    public function data() {
        $movies = $this->movieRepo->getAll();
        return view('data-movies', compact('movies'));
    }
}