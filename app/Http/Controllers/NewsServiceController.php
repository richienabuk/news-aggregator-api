<?php

namespace App\Http\Controllers;

use App\Services\News\Sources\GuardianNews;
use App\Services\News\Sources\NewsAPI;
use App\Services\News\Sources\NYTimes;
use Illuminate\Http\JsonResponse;

class NewsServiceController extends Controller
{
    /**
     * Load news from multiple sources
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        (new NYTimes())->load();
        (new GuardianNews())->load();
        (new NewsAPI())->load();

        return response()->json([
           'status' => true,
        ]);
    }
}
