<?php
declare(strict_types=1);

namespace App\GraphQL\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

class PersonalizedNewsArticle
{
    /**
     * @param Builder $builder
     * @param bool $value
     * @return Builder
     * @throws AuthenticationException
     */
    public function __invoke(Builder $builder, bool $value): Builder
    {
        if (!auth()->check()) {
            throw new AuthenticationException('Invalid login credentials provided.');
        }

        if (!$value) {
            return $builder;
        }

        // Might want to check this: auth()->hasUser but it's safe for our minimal app.

        $preferences = auth()->user()?->preferences;

        $authors = $preferences->where('key', 'Authors')->first()['value'] ?? [];
        $sources = $preferences->where('key', 'Sources')->first()['value'] ?? [];
        $categories = $preferences->where('key', 'Categories')->first()['value'] ?? [];

        // source, category and author
        return $builder->where(function ($query) use ($authors, $sources, $categories) {
            $query
                ->whereHas('authors', function ($query) use ($authors) {
                    $query->whereIn('authors.id', $authors);
                })
                ->orwhereIn('source_id', $sources)
                ->orwhereIn('category_id', $categories);
        });
    }
}
