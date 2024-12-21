<?php

namespace App\Repositories\Contracts;

use App\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function getPaginatedArticles(array $filters): LengthAwarePaginator;

    public function getArticleById(Article $article): Article;

    public function createArticle(array $data): Article;

    public function updateArticle(Article $article, array $data): Article;

    public function deleteArticle(Article $article): void;
}
