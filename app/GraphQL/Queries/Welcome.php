<?php

namespace App\GraphQL\Queries;

final class Welcome
{
    /**
     * @param null $_
     * @param array{} $args
     * @return string
     */
    public function __invoke($_, array $args): string
    {
        return 'Welcome';
    }
}
