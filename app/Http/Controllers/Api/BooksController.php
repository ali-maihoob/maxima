<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Book\BookRepository;
use App\Http\Resources\Book\BookResource;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;


class BooksController extends Controller
{
    use HttpResponse;
    protected BookRepository $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index(Request $request)
    {
        $searchQuery = $request->input('q');
        $sortCriteria = $request->input('sort_by', 'title'); // Default sorting criteria is 'title'
        $sortOrder = $request->input('sort_order', 'asc');

        $books = $this->bookRepository->all($searchQuery, $sortCriteria, $sortOrder);

        return BookResource::collection($books);
    }

    public function store(StoreBookRequest $request)
    {
        $imagePath = $this->handleImageUpload($request);

        $bookData = $request->all();
        $bookData['image'] = $imagePath;

        $book = $this->bookRepository->create($bookData);
        return BookResource::make($book);
    }

    public function update(UpdateBookRequest $request, $id)
    {
        $bookData = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $this->handleImageUpload($request);
            $bookData['image'] = $imagePath;
        }

        $book = $this->bookRepository->update($id, $bookData);
        return BookResource::make($book);
    }

    public function show($id) {
        $book = $this->bookRepository->find($id);
        return BookResource::make($book);
    }

    public function destroy($id)
    {
        $this->bookRepository->delete($id);
        return $this->success([], 'The Book has been deleted Successfully');
    }

    private function handleImageUpload($request)
    {
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('book_covers', 'public');
        }
        return $imagePath;
    }
}
