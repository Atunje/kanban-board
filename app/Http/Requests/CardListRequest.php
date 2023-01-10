<?php

namespace App\Http\Requests;

class CardListRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable|boolean',
            'date' => 'nullable|date'
        ];
    }
}
