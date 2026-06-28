<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'user_id',
        'title',
        'text',
    ];

    protected $allowedFilters = [
        'title' => Like::class,
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
