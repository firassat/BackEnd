<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
       'email',
         'password',
        'is_expert',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    Public function expert()
    {
        return $this->hasOne(Expert::class, 'experts_id');
    }
    public function favorite()
    {
        return $this->hasMany(Favorite::class,'users_id');
    }
    public function star()
    {
        return $this->hasMany(Star::class,'users_id');
    }
    public function BookedTime()
    {
        return $this->hasMany(BookedTime::class,'users_id');
    }
}
