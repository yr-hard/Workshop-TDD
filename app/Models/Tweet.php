<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Tweet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'photo',
    ];

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class);
    }

    public function getPhoto()
    {
        if ($this->photo) {
            return Storage::url($this->photo);
        }

        return null;
    }
}
