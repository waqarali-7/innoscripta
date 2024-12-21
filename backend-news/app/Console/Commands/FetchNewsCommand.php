<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Article;

class FetchNewsCommand extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch news from external APIs and save to the database';

    public function handle()
    {
        $this->info('Starting to fetch news articles...');

        try {
            $this->fetchFromNewsAPI();
            $this->fetchFromGuardian();
            $this->fetchFromNYTimes();

            $this->info('News articles fetched and saved successfully.');
        } catch (\Exception $e) {
            $this->error('An error occurred: ' . $e->getMessage());
            Log::error('FetchNewsCommand Error: ' . $e->getMessage());
        }
    }

    private function fetchFromNewsAPI()
    {
        $apiKey = env('NEWSAPI_KEY');
        $this->validateApiKey($apiKey, 'NEWSAPI_KEY');

        $url = 'https://newsapi.org/v2/top-headlines';
        $params = [
            'apiKey' => $apiKey,
            'country' => 'us',
            'category' => 'technology',
        ];

        $this->fetchAndSave($url, $params, 'NewsAPI', function ($article) {
            return [
                'title' => $article['title'] ?? null,
                'description' => $article['description'] ?? 'N/A',
                'content' => $article['content'] ?? 'N/A',
                'published_at' => $this->formatDate($article['publishedAt'] ?? null),
                'source' => $article['source']['name'] ?? 'Unknown',
                'author' => $article['author'] ?? 'Unknown',
                'url' => $article['url'] ?? null,
                'url_to_image' => $article['urlToImage'] ?? 'N/A',
                'category' => 'technology',
            ];
        });
    }

    private function fetchFromGuardian()
    {
        $apiKey = env('GUARDIAN_API_KEY');
        $this->validateApiKey($apiKey, 'GUARDIAN_API_KEY');

        $url = 'https://content.guardianapis.com/search';
        $params = [
            'api-key' => $apiKey,
            'section' => 'technology',
            'show-fields' => 'headline,body,thumbnail',
        ];

        $this->fetchAndSave($url, $params, 'The Guardian', function ($article) {
            return [
                'title' => $article['fields']['headline'] ?? null,
                'description' => 'N/A',
                'content' => $article['fields']['body'] ?? 'N/A',
                'published_at' => $this->formatDate($article['webPublicationDate'] ?? null),
                'source' => 'The Guardian',
                'author' => null,
                'url' => $article['webUrl'] ?? null,
                'url_to_image' => $article['fields']['thumbnail'] ?? 'N/A',
                'category' => 'technology',
            ];
        });
    }

    private function fetchFromNYTimes()
    {
        $apiKey = env('NYTIMES_API_KEY');
        $this->validateApiKey($apiKey, 'NYTIMES_API_KEY');

        $url = 'https://api.nytimes.com/svc/topstories/v2/technology.json';
        $params = ['api-key' => $apiKey];

        $this->fetchAndSave($url, $params, 'The New York Times', function ($article) {
            return [
                'title' => $article['title'] ?? null,
                'description' => $article['abstract'] ?? 'N/A',
                'content' => $article['url'] ?? 'N/A',
                'published_at' => $this->formatDate($article['published_date'] ?? null),
                'source' => 'The New York Times',
                'author' => $article['byline'] ?? 'Unknown',
                'url' => $article['url'] ?? null,
                'url_to_image' => $article['multimedia'][0]['url'] ?? 'N/A',
                'category' => 'technology',
            ];
        });
    }

    private function fetchAndSave($url, $params, $sourceName, $transform)
    {
        $this->info("Fetching data from $sourceName...");

        try {
            $response = Http::get($url, $params);

            if ($response->failed()) {
                $this->error("Failed to fetch data from $sourceName. HTTP Error: {$response->status()}");
                Log::error("Failed to fetch data from $sourceName. HTTP Error: {$response->status()}");
                return;
            }

            $articles = $response->json('articles') ?? $response->json('response.results') ?? [];

            foreach ($articles as $news) {
                $data = $transform($news);
                if ($data['title']) {
                    Article::updateOrCreate(['title' => $data['title']], $data);
                }
            }

            $this->info("Successfully fetched and saved articles from $sourceName.");
        } catch (\Exception $e) {
            $this->error("Error fetching data from $sourceName: " . $e->getMessage());
            Log::error("Error fetching data from $sourceName: " . $e->getMessage());
        }
    }

    private function validateApiKey($apiKey, $keyName)
    {
        if (empty($apiKey)) {
            $this->error("The API key for $keyName is missing in your .env file.");
            throw new \Exception("Missing API key: $keyName");
        }
    }

    private function formatDate($date)
    {
        return $date ? Carbon::parse($date)->format('Y-m-d H:i:s') : null;
    }
}
