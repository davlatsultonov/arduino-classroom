<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer', 'is_correct'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
