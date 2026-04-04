<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookComment extends Model
{
    use HasFactory;

    protected $table = 'book_comments';

    protected $fillable = [
        'user_id',
        'buku_id',
        'parent_id',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function parent()
    {
        return $this->belongsTo(BookComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(BookComment::class, 'parent_id')->with('user');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'user_id', 'user_id')
                    ->whereColumn('buku_id', 'buku_id');
    }
}