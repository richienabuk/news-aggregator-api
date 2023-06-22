<?php
declare(strict_types=1);

namespace App\Services\News;

use App\Models\Author;
use App\Models\Category;
use App\Models\News;
use App\Models\Source;
use Illuminate\Http\JsonResponse;

abstract class NewsData
{
    abstract protected function fetchNews();

    public function load(): JsonResponse
    {
        $data = $this->fetchNews();

        foreach ($data as $news) {
            if (!$news instanceof NewsTemplate) {
                continue;
            }

            if (News::where('url', $news->url)->first()) {
                continue;
            }

            // 1. find or create category
            $category = Category::firstOrCreate(['name' =>  $news->category]);

            // find or create source
            $source = Source::firstOrCreate(['name' =>  $news->source]);

            // find or create authors
            $authorIds = [];
            foreach ($news->authors as $author) {
                $author = trim($author);
                if (!$author) {
                    continue;
                }
                $authorIds[] = (Author::firstOrCreate(['name' =>  $author]))->id;
            }

            // add news
            $record = News::create([
                'title' => $news->title,
                'url' => $news->url,
                'source_id' => $source->id,
                'category_id' => $category->id,
                'published_at' => $news->published_at,
                'preview_image' => $news->preview_image,
                'description' => $news->description
            ]);

            // link authors
            if ($authorIds) {
                $record->authors()->attach($authorIds);
            }
        }

        return response()->json(['success' => true]);
    }
}
