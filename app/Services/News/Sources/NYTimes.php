<?php
declare(strict_types=1);

namespace App\Services\News\Sources;

use App\Services\News\NewsData;
use App\Services\News\NewsTemplate;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class NYTimes extends NewsData
{
    private string $baseUrl = 'https://api.nytimes.com/svc/news/v3/content/all/all.json';

    protected function fetchNews(): array
    {
        $res = [];
        $apiKey = env('NYTIMES_API_KEY');

        if (!$apiKey) {
            return $res;
        }

        $response = Http::get($this->baseUrl, [
            'limit' => 20,
            'api-key' => $apiKey
        ]);

        if (!$response->ok()) {
            return $res;
        }

        $data = $response->json()['results'];

        foreach ($data as $item) {
            $authors = str_replace('By', '', $item['byline']);
            $authors = array_map('trim', explode(',', str_replace('and' ,',', $authors)));

            $res[] = new NewsTemplate(
                $item['title'],
                $item['url'],
                $item['section'],
                $item['source'] ?? 'NYTimes',
                $authors,
                $item['published_date'],
                Arr::last($item['multimedia'])['url'],
                $item['abstract'],
            );
        }

        return $res;
    }
}
