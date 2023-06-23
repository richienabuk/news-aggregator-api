<?php
declare(strict_types=1);

namespace App\GraphQL\Builders;

use Illuminate\Database\Eloquent\Builder;

class SearchNewsArticle
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function __invoke(Builder $builder, string $value): Builder
    {
        return $builder->where(function ($query) use ($value) {
            $query
                ->where('title', 'like', "%$value%")
                ->orWhere('description', 'like', "%$value%");
        });
    }
}
