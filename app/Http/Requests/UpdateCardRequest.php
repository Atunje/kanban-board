<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCardRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cards')->ignore($this->get('id')),
            ],
            'description' => 'required|string|max:255',
        ];
    }
}
