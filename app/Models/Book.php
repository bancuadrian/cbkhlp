<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_id', 'title', 'published_date', 'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
