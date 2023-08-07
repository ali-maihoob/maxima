<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Book\BookRepository;
use App\Http\Resources\Book\BookResource;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Traits\HttpResponse;

class BooksController extends Controller
{
    use HttpResponse;
    protected BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index()
    {
        $books = $this->bookRepository->all();
        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        return BookResource::make($this->bookRepository->create($request->all()));
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $book = $this->bookRepository->update($id, $request->all());
        return BookResource::make($book);
    }

    public function destroy($id)
    {
        $this->bookRepository->delete($id);
        return $this->success([], 'The Book has been deleted Successfully');
    }
}
