<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['name', 'description'];

    /**
     * Relacionamento 1:N
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Artigo::class, 'category_id', 'id');
    }
}
