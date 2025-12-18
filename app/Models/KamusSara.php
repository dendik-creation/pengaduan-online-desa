<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KamusSara extends Model
{
    protected $table = 'kamus_sara';
    
    protected $fillable = [
        'kata',
    ];
}
