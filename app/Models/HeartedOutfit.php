<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeartedOutfit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'outfit_description',
        'weather_condition',
        'temperature',
        'image_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
