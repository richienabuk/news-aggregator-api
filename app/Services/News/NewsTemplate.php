<?php
declare(strict_types=1);

namespace App\Services\News;

class NewsTemplate
{
    /**
     * NewsTemplate constructor.
     * @param string $title
     * @param string $url
     * @param string $category
     * @param string $source
     * @param array $authors
     * @param string $published_at
     * @param string|null $preview_image
     * @param string|null $description
     */
    public function __construct(
        public readonly string   $title,
        public readonly string   $url,
        public readonly string   $category,
        public readonly string   $source,
        public readonly array    $authors,
        public readonly string   $published_at,
        public readonly ?string  $preview_image,
        public readonly ?string  $description,
    ) {
    }
}
