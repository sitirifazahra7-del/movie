<?php

namespace App\Services;

use App\Repositories\MovieRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MovieService
{
    protected $movieRepo;

    public function __construct(MovieRepository $movieRepo)
    {
        $this->movieRepo = $movieRepo;
    }

    public function storeMovie(array $data, $file = null)
    {
        if ($file) {
            $data['foto_sampul'] = $this->handleUpload($file);
        }
        return $this->movieRepo->create($data);
    }

    public function updateMovie($id, array $data, $file = null)
    {
        $movie = $this->movieRepo->findById($id);
        if ($file) {
            // Hapus foto lama
            if (File::exists(public_path('images/' . $movie->foto_sampul))) {
                File::delete(public_path('images/' . $movie->foto_sampul));
            }
            $data['foto_sampul'] = $this->handleUpload($file);
        }
        return $this->movieRepo->update($id, $data);
    }

    private function handleUpload($file)
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $fileName);
        return $fileName;
    }
}