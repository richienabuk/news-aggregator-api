<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
