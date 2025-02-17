<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'description'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function articleImages(): HasMany
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function firstImage(): Attribute
    {
        return new Attribute(
            fn () => $this->articleImages->first()
        );
    }

    public function dateTime(): Attribute
    {
        return Attribute::make(
            fn() => $this->created_at->diffForHumans([
                'parts' => 2
            ])
        );
    }
}
