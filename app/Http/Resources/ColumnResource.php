<?php

namespace App\Http\Resources;

use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Column */
class ColumnResource extends JsonResource
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
            'cards' => CardResource::collection($this->cards)->resource,
            'created_at' => $this->created_at
        ];
    }
}
