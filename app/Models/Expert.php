<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;
    public function user(){
        $this->belongsTo(User::class);
    }
    public function favorite()
    {
        $this->hasMany(Favorite::class,'expert_id');
    }
    public function star()
    {
        $this->hasOne(Star::class,'expert_id');
    }
    
}
