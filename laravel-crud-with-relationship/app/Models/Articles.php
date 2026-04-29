<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articles extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'published_at',
        'category_id'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = ['published_at' => 'datetime',];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
