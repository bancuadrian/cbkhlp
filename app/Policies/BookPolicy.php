<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user)
    {
        return Response::allow();
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
