<?php

namespace App\Http\Requests;

class StoreCardRequest extends APIFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'column_id' => 'required|integer|exists:columns,id',
            'position' =>'required|integer'
        ];
    }
}
