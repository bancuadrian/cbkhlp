<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('author_id');
            $table->string('title');
            $table->date('published_date');
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->unique(['author_id', 'title']);

            $table
                ->foreign('author_id')
                ->references('id')
                ->on('authors');

            $table
                ->foreign('created_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
