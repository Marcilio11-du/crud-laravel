<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleUser extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'article_id',
        'user_id',
    ];

    protected $dates = ['deleted_at'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
