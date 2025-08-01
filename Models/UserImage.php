<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserImage extends Model
{
    protected $fillable = ['user_id', 'path'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
