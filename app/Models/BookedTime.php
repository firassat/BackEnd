<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedTime extends Model
{
    use HasFactory;
    public function expert()
{
    return $this->belongsTo(Expert::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
