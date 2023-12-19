<?php

namespace App\Http\Requests;

use App\Http\Traits\ResponseAPI;
use App\Rules\Url;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ShortenUrlRequest extends FormRequest
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
            'url' => ['required', 'max:255', 'min:8', new Url],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = implode(' ', $validator->getMessageBag()->all());
        throw new HttpResponseException($this->error($message, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
