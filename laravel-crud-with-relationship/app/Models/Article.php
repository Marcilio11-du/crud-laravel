<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use SoftDeletes;
    protected $fillable = ['title', 'content', 'publishing_date', 'cover_path', 'category_id'];

    protected $casts = [
        'publishing_date' => 'datetime',
    ];

    /**
     * Se publishing_date for nulo ao criar, assume o timestamp actual.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->publishing_date)) {
                $model->publishing_date = now();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_user');
    }
}
