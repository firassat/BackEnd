<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'expert_id',
        'user_id',
        'day_id',
        'time',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function expert()
{
    return $this->belongsTo(Expert::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}
}
