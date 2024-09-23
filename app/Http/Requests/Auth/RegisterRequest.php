<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BikeMapRequest;

class RegisterRequest extends BikeMapRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required',
            'password' => 'min:8|required|confirmed',
        ];
    }
}
