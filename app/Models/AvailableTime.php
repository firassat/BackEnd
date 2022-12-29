<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableTime extends Model
{
    use HasFactory;
    protected $fillable = [
        'expert_id',
        'day_id',
        'time_from',
        'time_to',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function expert()
{
    return $this->belongsTo(Expert::class);
}
}
