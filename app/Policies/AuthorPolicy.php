<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * AuthorPolicy constructor.
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

    public function create(User $user)
    {
        return Response::allow();
    }

    public function update(User $user, Author $author)
    {
        return $user->id == $author->created_by;
    }

    public function delete(User $user, Author $author)
    {
        return $user->id == $author->created_by;
    }
}
