<?php

namespace App\Services;

use App\Models\Matricula;

class MatriculaServices {

    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return Matricula::create($data);
    }

    public function update(array $data, int $id)
    {
        //
    }

    public function delete(int $id)
    {
        //
    }

    public function get(int $id)
    {
        //
    }

    public function getAll()
    {
        //
    }

    public function getAllPaginated(int $paginate)
    {

    }
}
