<?php

namespace App\Http\Requests;

use DateTimeZone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'first_name' => ['required', 'string'],
            'last_name'  => ['required', 'string'],
            'email'      => ['required', 'email', 'unique:users'],
            'address'    => ['required', 'string'],
            'city'       => ['required', 'string'],
            'country'    => ['required', 'string'],
            'birth_date' => ['required', 'date_format:Y-m-d'],
            'timezone'   => ['sometimes', Rule::in(DateTimeZone::listIdentifiers())],
        ];
    }
}
