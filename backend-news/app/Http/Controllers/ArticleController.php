<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 *
 * Handles CRUD operations for articles and applies user preferences.
 */
class ArticleController extends BaseController
{
    protected ArticleService $service;

    /**
     * ArticleController Constructor
     *
     * @param ArticleService $service
     */
    public function __construct(ArticleService $service)
    {
        $this->service = $service;
    }

    /**
     * Fetch paginated articles based on filters, preferences, and search query.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = $request->all();

        if ($request->user()) {
            $filters['preferences'] = $request->user()->preferences;
        }

        $articles = $this->service->fetchArticles($filters);

        return $this->sendSuccess($articles, 'Articles fetched successfully.');
    }

    /**
     * Store a new article.
     *
     * @param StoreArticleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreArticleRequest $request)
    {
        $article = $this->service->createArticle($request->validated());
        return $this->sendSuccess($article, 'Article created successfully.', 201);
    }

    /**
     * Retrieve a specific article.
     *
     * @param Article $article
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Article $article, Request $request)
    {
        $preferences = $request->user()?->preferences;

        if ($preferences) {
            if (
                (!empty($preferences['sources']) && !in_array($article->source, $preferences['sources'])) ||
                (!empty($preferences['categories']) && !in_array($article->category, $preferences['categories'])) ||
                (!empty($preferences['authors']) && !in_array($article->author, $preferences['authors']))
            ) {
                return $this->sendError('You are not authorized to view this article.', [], 403);
            }
        }

        return $this->sendSuccess($this->service->getArticle($article), 'Article retrieved successfully.');
    }

    /**
     * Update an existing article.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $updatedArticle = $this->service->updateArticle($article, $request->validated());

        return $this->sendSuccess($updatedArticle, 'Article updated successfully.');
    }

    /**
     * Delete an article.
     *
     * @param Article $article
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $this->service->deleteArticle($article);
        return $this->sendSuccess([], 'Article deleted successfully.');
    }
}
