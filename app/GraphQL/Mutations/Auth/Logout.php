<?php

namespace App\GraphQL\Mutations\Auth;

use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class Logout
{
    /**
     * @param null $_
     * @param array{} $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return string[]
     */
    public function __invoke($_, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        $context->user()?->currentAccessToken()->delete();
        return [
            'status' => true,
            'message' => 'Logout successfully.'
        ];
    }
}
