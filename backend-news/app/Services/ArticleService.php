<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ArticleService
 * @package App\Services
 *
 * Handles business logic for articles.
 */
class ArticleService
{
    protected ArticleRepositoryInterface $repository;

    /**
     * ArticleService Constructor
     *
     * @param ArticleRepositoryInterface $repository
     */
    public function __construct(ArticleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetch paginated articles based on filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function fetchArticles(array $filters): LengthAwarePaginator
    {
        return $this->repository->getPaginatedArticles($filters);
    }

    /**
     * Retrieve a single article.
     *
     * @param Article $article
     * @return Article
     */
    public function getArticle(Article $article): Article
    {
        return $this->repository->getArticleById($article);
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data): Article
    {
        return $this->repository->createArticle($data);
    }

    /**
     * Update an existing article.
     *
     * @param Article $article
     * @param array $data
     * @return Article
     */
    public function updateArticle(Article $article, array $data): Article
    {
        return $this->repository->updateArticle($article, $data);
    }

    /**
     * Delete an article.
     *
     * @param Article $article
     * @return void
     */
    public function deleteArticle(Article $article): void
    {
        $this->repository->deleteArticle($article);
    }
}
