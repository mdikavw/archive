<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drawer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function moderators()
    {
        return $this->belongsToMany(User::class, 'draweruser')->wherePivot('is_moderator', true)->withTimestamps();
    }

    public function subsribers()
    {
        return $this->belongsToMany(User::class, 'draweruser')->withTimestamps();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
