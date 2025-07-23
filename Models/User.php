<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Content;
use App\Enums\UserType;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'phone', 'password', 'user_type', 'status'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
       'user_type' => UserType::class
    ];

    public function isAdmin(): bool
    {
        return $this->user_type === UserType::ADMIN;
    }

    public function isClient(): bool
    {
        return $this->user_type === UserType::CLIENT;
    }
    public function contents()
    {
        return $this->belongsToMany(Content::class, 'content_users', 'user_id', 'content_id')->withTimestamps();
    }
    public function profileImage()
    {
        return $this->hasOne(UserImage::class);
    }
    public function getProfileImageUrlAttribute()
    {
        return $this->profileImage ? asset($this->profileImage->path) : '';
    }
}
