<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    public function user(){
        return  $this->belongsTo(User::class);
    }
    public function favorite()
    {
        return $this->hasMany(Favorite::class,'expert_id');
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
