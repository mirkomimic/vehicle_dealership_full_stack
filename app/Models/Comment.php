<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // protected $with = [
    //     'replies',
    // ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')
            ->with('user')
            ->with('replies')
            ->orderBy('created_at', 'DESC');
    }

    // public function allReplies()
    // {
    //     return $this->replies()->with('allReplies');
    // }
}
