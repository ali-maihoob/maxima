<?php

namespace App\Repositories\Book;

interface BookRepositoryInterface
{

    public function all($searchQuery, $sortCriteria);

    public function find($id);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);
}
