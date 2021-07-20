<?php

namespace App\Http\Controllers;

use App\Http\Filters\BookFilter;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookApiController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }

    public function index(BookFilter $bookFilter)
    {
        return Book::with('author')
            ->filter($bookFilter)
            ->paginate(15);
    }

    public function show(Book $book)
    {
        return $book;
    }
}
