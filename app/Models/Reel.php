<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'reel_path', 'thumbnail_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
