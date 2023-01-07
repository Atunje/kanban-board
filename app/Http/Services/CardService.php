<?php

namespace App\Http\Services;

use App\Http\Resources\CardListResource;
use App\Models\Card;
use App\Http\Resources\CardResource;
use DB;
use Illuminate\Support\Fluent;
use Throwable;

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
        if($this->shiftCards($card, $data['position']) && $card->update($data)) {
            return true;
        }

        return false;
    }

    private function shiftCards(Card $card, int $position): bool
    {
        try {
            DB::transaction(function () use ($card, $position) {
                $cards = Card::where('position', '>=', $position)
                    ->where('column_id', $card->column_id)
                    ->get();

                foreach ($cards as $card) {
                    $card->position += 1;
                    $card->save();
                }
            });

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
