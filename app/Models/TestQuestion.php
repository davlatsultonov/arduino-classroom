<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function testResult()
    {
        return $this->hasOne(TestResult::class);
    }

    public function testAnswers()
    {
        return $this->hasMany(TestAnswer::class);
    }
}
