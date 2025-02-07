<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    private $model;

    public function __construct(Article $model)
    {
        $this->model = $model;
    }

    public function save(Article $article)
    {
        $article->save();

        return $article;
    }
}