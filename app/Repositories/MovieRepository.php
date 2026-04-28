<?php

namespace App\Repositories;

use App\Models\Movie;

class MovieRepository
{
    public function getAll()
    {
    return Movie::paginate(6); 
    }

    public function findById($id)
    {
        return Movie::findOrFail($id);
    }

    public function create(array $data)
    {
        return Movie::create($data);
    }

    public function update($id, array $data)
    {
        $movie = $this->findById($id);
        $movie->update($data);
        return $movie;
    }

    public function delete($id)
    {
        $movie = $this->findById($id);
        return $movie->delete();
    }
}