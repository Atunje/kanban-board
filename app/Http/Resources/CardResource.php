<?php

namespace App\Http\Resources;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Card */
class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'position' => $this->position,
            'column_id' => $this->column_id,
            'created_at' => $this->created_at,
        ];
    }
}
