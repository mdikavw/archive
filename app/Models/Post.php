<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'content', 'slug', 'type', 'user_id', 'archive_id'
    ];

    // protected $with = ['user', 'drawer'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function drawer()
    {
        return $this->belongsTo(Drawer::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'reactable');
    }

    public function reactedByLoggedUser()
    {
        return $this->reactions()->where('user_id', auth()->id());
    }
}
