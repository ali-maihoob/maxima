<?php

namespace App\Repositories\Book;
use App\Models\Book;
class BookRepository implements BookRepositoryInterface {

    public function all($searchQuery = null, $sortCriteria = 'title')
    {
        $query = Book::query();

        if ($searchQuery) {
            $query->where('title', 'like', '%' . $searchQuery . '%')
                ->orWhere('author', 'like', '%' . $searchQuery . '%')
                ->orWhere('description', 'like', '%' . $searchQuery . '%');
        }

        $query->orderBy($sortCriteria);

        return $query->paginate(5);
    }

    public function find($id)
    {
        return Book::findOrFail($id);
    }

    public function create(array $data)
    {
        return Book::create($data);
    }

    public function update($id, array $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book;
    }

    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
    }
}
