<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'tel',
        'users_id',
        'image'
    ];

    public function user(){
        return  $this->belongsTo(User::class,'users_id');
    }
    public function favorite()
    {
        return $this->hasMany(Favorite::class,'expert_id');
    }
    public function experiences()
    {
        return $this->hasMany(Experiences::class,'expert_id');
    }
    public function AvailableTime()
    {
        return $this->hasMany(AvailableTime::class,'expert_id');
    }
    public function BookedTime()
    {
        return $this->hasMany(BookedTime::class,'expert_id');
    }
    public function star()
    {
        return $this->hasOne(Star::class,'expert_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'experts-categories');
    }
}
