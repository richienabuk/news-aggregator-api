<?php

namespace App\GraphQL\Validators;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Validation\Validator;

final class UpsertUserPreferenceInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array>
     */
    public function rules(): array
    {
        return [
            'key' => [Rule::unique('user_preferences', 'key')->where('user_id', auth()->id())],
        ];
    }

    public function messages(): array
    {
        return [
            'key.unique' => 'An entry with chosen key already exist. Update or remove it.',
        ];
    }
}
