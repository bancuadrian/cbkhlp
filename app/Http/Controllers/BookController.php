<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Book::class, 'book');
    }

    public function index()
    {
        $data = Book::with('author')
            ->orderBy('published_date', 'desc')
            ->get();
        $authors = Author::orderBy('name')
            ->get();

        return Inertia::render('Books', [
            'data' => $data,
            'authors' => $authors
        ]);
    }

    public function store(Request $request, Book $book)
    {
        $bookUniqueRule = Rule::unique(Book::class)->where(function ($query) use ($request) {
            return $query->where('title', $request->get('title'))
                ->where('author_id', $request->get('author_id'));
        });
        $rules = [
            'title' => ['required', $bookUniqueRule],
            'author_id' => ['required', 'exists:App\Models\Author,id'],
            'published_date' => ['required', 'date_format:Y-m-d']
        ];
        $validationMessages = [
            'title.unique' => 'This title by this author was already created'
        ];

        Validator::make($request->all(), $rules, $validationMessages)
            ->validate();

        $book->fill($request->all());
        $book->created_by = Auth::user()->id;
        $book->save();

        return Redirect::route('books.index');
    }

    public function update(Request $request, Book $book)
    {
        $bookUniqueRule = Rule::unique(Book::class)
            ->where(function ($query) use ($request) {
                return $query->where('title', $request->get('title'))
                    ->where('author_id', $request->get('author_id'));
            })->ignore($book->id);
        $rules = [
            'title' => ['required', $bookUniqueRule],
            'author_id' => ['required', 'exists:App\Models\Author,id'],
            'published_date' => ['required', 'date_format:Y-m-d']
        ];
        $validationMessages = [
            'title.unique' => 'This title by this author was already created'
        ];

        Validator::make($request->all(), $rules, $validationMessages)
            ->validate();

        if ($request->has('id')) {
            Book::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message', 'Book Updated Successfully.');
        }
    }

    public function destroy(Request $request, Book $book)
    {
        if ($request->has('id')) {
            Book::find($request->input('id'))->delete();
            return redirect()->back();
        }
    }
}
