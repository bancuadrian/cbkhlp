<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tableNames as $name) {
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }

        $createUsers = [
            'user1@example.com',
            'user2@example.com',
        ];

        foreach ($createUsers as $email) {
            \App\Models\User::factory(['email' => $email])
                ->has(Author::factory()
                    ->has(Book::factory()->count(10)->state(function (array $attributes, Author $author) {
                        return ['created_by' => $author->createdBy->id];
                    }), 'books')
                    ->count(3), 'authors')
                ->create();
        }
    }
}
