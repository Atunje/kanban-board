<?php

namespace App\Http\Requests;

class AddCardToColumnRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'position' => 'required|integer|min:0',
            'column_id' => 'required|integer|exists:columns,id',
        ];
    }
}
