<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    use HasFactory;
    protected $fillable = [
       'user_id',
       'expert_id',
       'numberofstars'
    ];
public function user()
{
    return $this->belongsTo(User::class);
}
public function expert()
{
    return $this->belongsTo(Expert::class);
}
}
