<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function scopeHasCompletedTests($q)
    {
        $q->whereHas('tests.testQuestions.testResults', fn($q) => $q->whereUserId(auth()->id()));
    }

    public function scopeSlug($q, $slug)
    {
        return $q->whereSlug($slug)->first()->name;
    }
}
