<?php

namespace App\Http\Requests;

use App\Http\Traits\ResponseAPI;
use App\Rules\PersonNameRules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserRequest extends FormRequest
{
    use ResponseAPI;
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
            'name' => ['required', 'max:16', new PersonNameRules],
            'email' => ['required', 'email', 'string', 'lowercase', 'unique:users', 'max:64'],
            'password' => ['required', 'max:32', Password::defaults()],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = implode(" ", $validator->getMessageBag()->all());
        throw new HttpResponseException($this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY));
    }

}
