<?php

namespace App\Http\Requests;

use App\Traits\HandlesResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

abstract class APIFormRequest extends FormRequest
{
    use HandlesResponse;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    abstract public function rules(): array;

    /**
     * Customize the response when validation fails.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->jsonResponse(
                statusCode: Response::HTTP_UNPROCESSABLE_ENTITY,
                message: __('validation.invalid_inputs'),
                errors: $validator->errors()->toArray()
            )
        );
    }

    public function validFields(): array
    {
        return (array) $this->validated();
    }

    public function integer($key, $default = 0): int
    {
        $field = $this->validFields();
        return $field[$key] ?? $default;
    }
}
