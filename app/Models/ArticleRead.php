<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleRead extends Model
{
    use HasFactory;

    protected $table = 'articles_read';

    protected $fillable = ['article_id', 'user_id'];
}
