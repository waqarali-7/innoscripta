<?php

namespace App\Repositories;

use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ArticleRepository
 * @package App\Repositories
 *
 * Handles database interactions for articles.
 */
class ArticleRepository implements ArticleRepositoryInterface
{
    /**
     * Get paginated articles based on filters.
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getPaginatedArticles(array $filters): LengthAwarePaginator
    {
        $query = Article::query();

        if (!empty($filters['preferences'])) {
            $preferences = $filters['preferences'];
            $query->when(!empty($preferences['sources']), fn ($q) => $q->whereIn('source', $preferences['sources']));
            $query->when(!empty($preferences['categories']), fn ($q) => $q->whereIn('category', $preferences['categories']));
            $query->when(!empty($preferences['authors']), fn ($q) => $q->whereIn('author', $preferences['authors']));
        }

        $query->when(!empty($filters['search']), function ($q) use ($filters) {
            $search = $filters['search'];
            $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('author', 'LIKE', "%{$search}%");
        });

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
            $query->whereBetween('published_at', [$filters['from_date'], $filters['to_date']]);
        }

        $sortField = $filters['sort_field'] ?? 'published_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        return $query->orderBy($sortField, $sortOrder)
            ->paginate($filters['per_page'] ?? 10);
    }

    /**
     * Retrieve a single article.
     *
     * @param Article $article
     * @return Article
     */
    public function getArticleById(Article $article): Article
    {
        return $article;
    }

    /**
     * Create a new article.
     *
     * @param array $data
     * @return Article
     */
    public function createArticle(array $data): Article
    {
        return Article::create($data);
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
        $article->update($data);
        return $article;
    }

    /**
     * Delete an article.
     *
     * @param Article $article
     * @return void
     */
    public function deleteArticle(Article $article): void
    {
        $article->delete();
    }
}
