<?php

namespace App\Http\Services;

use App\Http\Resources\CardListResource;
use App\Models\Card;
use App\Http\Resources\CardResource;
use Illuminate\Support\Fluent;

class CardService {

    public function create(array $data): CardResource
    {
        $card = Card::create($data);
        return new CardResource($card);
    }

    public function listCards(array $filterParams): mixed
    {
        $filterParams = new Fluent($filterParams);
        return CardListResource::collection(Card::getAll($filterParams))->resource;
    }

    public function update(Card $card, array $data): bool
    {
        return $card->update($data);
    }
}
