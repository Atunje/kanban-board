<?php

namespace App\Http\Requests;

class CardShiftRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'new_position' => 'required|integer|min:0',
        ];
    }
}
