<?php
declare(strict_types=1);

namespace App\Services\News\Sources;

use App\Services\News\NewsData;
use App\Services\News\NewsTemplate;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class GuardianNews extends NewsData
{
    private string $baseUrl = 'https://content.guardianapis.com/search';

    protected function fetchNews(): array
    {
        $res = [];
        $apiKey = env('THE_GUARDIAN_API_KEY');

        $response = Http::get($this->baseUrl, [
            'api-key' => $apiKey,
            'page-size' => 20,
            'from-date' => date('Y-m-d'),
            'show-fields' => 'byline,thumbnail,trailText',
        ]);

        if (!$response->ok()) {
            return $res;
        }

        $data = $response->json()['response']['results'];

        foreach ($data as $item) {
            $authors = Arr::get($item, 'fields.byline');
            $authors = str_replace(['(and)', '(earlier)', '(now)', 'editor', 'agency', 'clarifications', 'column', 'By', 'by'], '', $authors);
            $authors = array_map('trim', explode(',',str_replace( ['|', 'and', ';'] ,',', $authors)));

            $res[] = new NewsTemplate(
                $item['webTitle'],
                $item['webUrl'],
                $item['sectionName'],
                'TheGuardian',
                $authors,
                Carbon::parse($item['webPublicationDate'])->format('Y-m-d h:i:s'),
                Arr::get($item, 'fields.thumbnail'),
                Arr::get($item, 'fields.trailText'),
            );
        }

        return $res;
    }
}
