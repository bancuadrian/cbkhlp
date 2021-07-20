<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Author::class, 'author');
    }


    public function index()
    {
        $data = Author::orderBy('name', 'asc')
            ->get();

        return Inertia::render('Authors', [
            'data' => $data
        ]);
    }

    public function store(Request $request, Author $author)
    {
        $rules = [
            'name' => ['required', 'min:3', "unique:App\Models\Author,name"],
        ];
        $validationMessages = [
            'title.unique' => 'This title by this author was already created'
        ];

        Validator::make($request->all(), $rules, $validationMessages)
            ->validate();

        $author->fill($request->all());
        $author->created_by = Auth::user()->id;
        $author->save();

        return Redirect::route('authors.index');
    }

    public function update(Request $request, Author $author)
    {
        $rules = [
            'name' => ['required', 'min:3', "unique:App\Models\Author,name," . $author->id],
        ];
        $validationMessages = [
            'title.unique' => 'This title by this author was already created'
        ];

        Validator::make($request->all(), $rules, $validationMessages)
            ->validate();

        $author->fill($request->all());
        $author->created_by = Auth::user()->id;
        $author->save();

        return Redirect::route('authors.index');
    }

    public function destroy(Author $author)
    {
        $hasBooks = Book::where('author_id', $author->id)->count();

        if($hasBooks) {
            return redirect()->back()->with('flash-message','message');
        }

        $author->delete();

        return Redirect::route('authors.index');
    }
}
