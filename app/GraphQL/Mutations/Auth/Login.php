<?php

namespace App\GraphQL\Mutations\Auth;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;

final class Login
{
    /**
     * @param null $_
     * @param array{} $args
     * @return array
     * @throws AuthenticationException
     */
    public function __invoke($_, array $args): array
    {
        $user = User::where('email', $args['email'])->first();

        if (!$user || !Hash::check($args['password'], $user->password)) {
            throw new AuthenticationException('Invalid login credentials provided.');
        }

        $expires = Carbon::now()->addDays(5);

        return [
            'status' => true,
            'message' => 'User logged in successfully.',
            'token_type' => 'Bearer',
            'expires_at' => $expires,
            'access_token' => $user->createToken($args['device'] ?? 'Default', ['*'], $expires)->plainTextToken,
            'user' => $user,
        ];
    }
}
