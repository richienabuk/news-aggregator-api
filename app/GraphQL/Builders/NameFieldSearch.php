<?php
declare(strict_types=1);

namespace App\GraphQL\Builders;

use Illuminate\Database\Eloquent\Builder;

class NameFieldSearch
{
    /**
     * @param Builder $builder
     * @param string $value
     * @return Builder
     */
    public function __invoke(Builder $builder, string $value): Builder
    {
        return $builder->where('name', 'like', "%$value%");
    }
}
