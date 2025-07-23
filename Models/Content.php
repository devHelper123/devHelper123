<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $table = 'contents';

    protected $fillable = ['title', 'body'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'content_users', 'content_id', 'user_id')->withTimestamps();
    }
}
