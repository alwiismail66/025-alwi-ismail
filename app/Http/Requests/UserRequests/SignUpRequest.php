<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SignUpRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users', 'min:6', 'max:30'],
            'name' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'max:30'],
            'password_confirmation' => ['required', 'string', 'min:6', 'max:30'],
        ];
    }

    public function messages(): array
    {
        return [
            'password_confirmation.required' => 'The repeat password field is required'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $validate = $validator->safe();
                if ($validate->password !== $validate->password_confirmation) {
                    $validator->errors()->add(
                        'password',
                        'The password field and the repeat password field does not match.'
                    )
                        ->add('password_confirmation', 'The password field and the repeat password field does not match.');
                }
            }
        ];
    }
}
