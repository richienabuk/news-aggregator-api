<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Carbon\Carbon;

final class SignUp
{
    /**
     * @param null $_
     * @param array{} $args
     * @return array
     */
    public function __invoke($_, array $args): array
    {
        $user = User::create([
            'name' => $args['name'],
            'email' => $args['email'],
            'password' => $args['password']
        ]);

        $expires = Carbon::now()->addDays(5);

        return [
            'status' => true,
            'message' => 'User account created successfully.',
            'token_type' => 'Bearer',
            'expires_at' => $expires,
            'access_token' => $user->createToken($args['device'] ?? 'Default', ['*'], $expires)->plainTextToken,
            'user' => $user,
        ];
    }
}
