<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class BookPolicy
{
    use HandlesAuthorization;


    /**
     * BookPolicy constructor.
     */
    public function __construct()
    {
        $user = Auth::user();

        $fn = function ($query) use ($user) {
            $query->where('created_by', $user->id);
        };

        Book::addGlobalScope('user_filter', $fn);
    }

    public function viewAny(User $user)
    {
        return Response::allow();
    }

    public function view(User $user, Book $book)
    {
        return $book->created_by == $user->id;
    }

    public function create(User $user)
    {
        return Response::allow();
    }

    public function update(User $user, Book $book)
    {
        return $user->id == $book->created_by;
    }

    public function delete(User $user, Book $book)
    {
        return $user->id == $book->created_by;
    }
}
