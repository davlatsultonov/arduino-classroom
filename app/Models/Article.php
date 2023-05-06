<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'image', 'created_by', 'views'
    ];

    public function user()
    {
       return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
       return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
       return $this->belongsTo(SubCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function scopePopular($q)
    {
        return $q->where('views','>', 40);
    }
}
