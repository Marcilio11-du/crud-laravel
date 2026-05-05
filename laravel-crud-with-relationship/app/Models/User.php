<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = ['fst_name', 'sur_name', 'birth_date'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Relacionamento N:N
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_user', 'user_id', 'article_id')
            ->withTimestamps()
            ->withPivot('deleted_at');
    }
}
