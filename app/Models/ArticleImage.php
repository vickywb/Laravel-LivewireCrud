<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleImage extends Model
{
    protected $fillable = [
        'article_id', 'file_id'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    //Accessor
    protected function showFile(): Attribute
    {
        return new Attribute (
        fn () => Storage::url($this->file->location)
        );
    }
}
