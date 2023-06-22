<?php
declare(strict_types=1);

namespace App\Services\News\Sources;

use App\Services\News\NewsData;
use App\Services\News\NewsTemplate;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class NewsAPI extends NewsData
{
    private string $baseUrl = 'https://newsapi.org/v2/everything';

    /**
     * @return array
     */
    protected function fetchNews(): array
    {
        $res = [];
        $category = Arr::random(['Technology', 'Politics', 'Entertainment', 'Trading']);
        $apiKey = env('NEWS_API_KEY');

        if (!$apiKey) {
            return $res;
        }

        $response = Http::get($this->baseUrl, [
            'q' => $category,
            // I choose yesterday because I wasn't getting data for today query
            'from' => Carbon::yesterday()->format('Y-m-d'),
            'sortBy' => 'publishedAt',
            'apiKey' => $apiKey,
            'pageSize' => 20,
        ]);

        if (!$response->ok()) {
            return $res;
        }

        $data = $response->json()['articles'];

        foreach ($data as $item) {
            $source = $item['source']['name'] ?? 'NewsAPI';

            $authors = trim($item['author'] ?? '');
            $authors = $authors ?: $source;
            $authors = array_map('trim', explode(',', $authors));

            $res[] = new NewsTemplate(
                $item['title'] ?? 'No title',
                $item['url'],
                $category,
                $source,
                $authors,
                Carbon::parse($item['publishedAt'])->format('Y-m-d h:i:s'),
                $item['urlToImage'],
                $item['description'],
            );
        }

        return $res;
    }
}
