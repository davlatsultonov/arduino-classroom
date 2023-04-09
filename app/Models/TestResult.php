<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'test_question_id', 'test_answer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testQuestion()
    {
        return $this->belongsTo(TestQuestion::class);
    }
}
