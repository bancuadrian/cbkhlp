<?php

namespace App\Listeners;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Auth\Events\Authenticated;

class AuthenticatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        $fn = function ($query) use ($event) {
            $query->where('created_by', $event->user->id);
        };

        Book::addGlobalScope('user_filter', $fn);
        Author::addGlobalScope('user_filter', $fn);
    }
}
