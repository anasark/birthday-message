<?php

namespace App\Http\Requests;

use DateTimeZone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'string'],
            'last_name'  => ['sometimes', 'string'],
            'email'      => ['sometimes', 'email', 'unique:users'],
            'address'    => ['sometimes', 'string'],
            'city'       => ['sometimes', 'string'],
            'country'    => ['sometimes', 'string'],
            'birth_date' => ['sometimes', 'date_format:Y-m-d'],
            'timezone'   => ['sometimes', Rule::in(DateTimeZone::listIdentifiers())],
        ];
    }
}
