<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Repositories\MovieRepository;
use App\Http\Requests\StoreMovieRequest;
use App\Models\Category;

class MovieController extends Controller
{
    protected $movieService;
    protected $movieRepo;

    public function __construct(MovieService $movieService, MovieRepository $movieRepo)
    {
        $this->movieService = $movieService;
        $this->movieRepo = $movieRepo;
    }

    public function index()
    {
        $movies = $this->movieRepo->getAll();
        return view('movies.homepage', compact('movies'));
    }

    public function detail($id)
    {
        $movie = $this->movieRepo->findById($id);
        return view('movies.detail', compact('movie'));
    }

    public function data()
    {
        $movies = $this->movieRepo->getAll();
        return view('movies.data-movies', compact('movies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('movies.input', compact('categories'));
    }

    public function store(StoreMovieRequest $request)
    {
        $this->movieService->storeMovie($request->validated(), $request->file('foto_sampul'));
        return redirect('/')->with('success', 'Film berhasil ditambahkan.');
    }

    public function form_edit($id)
    {
        $movie = $this->movieRepo->findById($id);
        $categories = Category::all();
        return view('movies.form-edit', compact('movie', 'categories'));
    }

    public function update(StoreMovieRequest $request, $id)
    {
        $this->movieService->updateMovie($id, $request->validated(), $request->file('foto_sampul'));
        return redirect('/movies/data')->with('success', 'Film berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->movieRepo->delete($id);
        return redirect('/movies/data')->with('success', 'Film berhasil dihapus.');
    }
}

