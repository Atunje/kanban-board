<?php

namespace App\Http\Services;

use DB;
use Throwable;
use App\Models\Card;
use App\Models\Column;
use Illuminate\Support\Fluent;
use App\Http\Resources\CardResource;
use App\Http\Resources\CardListResource;

class CardService {

    public function create(array $data): CardResource
    {
        $data['position'] = $this->getNewCardPosition($data['column_id']);
        $card = Card::create($data);
        return new CardResource($card);
    }

    private function getNewCardPosition(int $columnId): int
    {
        return Column::findOrFail($columnId)->cards->count();
    }

    public function listCards(array $filterParams): mixed
    {
        return CardListResource::collection(Card::getAll($filterParams))->resource;
    }

    public function update(Card $card, array $data): bool
    {
        return $card->update($data);
    }

    public function addCard(Card $currentCard, int $columnId, int $position): bool
    {
        try {
            DB::transaction(function () use ($currentCard, $columnId, $position) {
                $this->removeFromColumn($currentCard);
                $this->addToColumn($currentCard, $columnId, $position);
            });
            return true;
        } catch (Throwable) {
            return false;
        }

    }

    private function addToColumn(Card $currentCard, int $columnId, int $position): void
    {
        //open the space
        $cards = Card::where(['column_id' => $columnId])->where('position', '>=', $position)->get();

        foreach($cards as $card) {
            $card->shiftDown();
        }

        $column = Column::findOrFail($columnId);
        $currentCard->setInPosition($position, $column);
    }

    private function removeFromColumn(Card $currentCard): void
    {
        $cards = Card::where('column_id', $currentCard->column_id)->where('position', '>', $currentCard->position)->get();

        foreach($cards as $card) {
            $card->shiftUp();
        }
    }

    public function shiftCard(Card $card, int $newPosition): bool
    {
        $oldPosition = $card->position;

        if($newPosition > $oldPosition) {
            $this->shiftCardsUp($card, $oldPosition, $newPosition);
        } else {
            $this->shiftCardsDown($card, $oldPosition, $newPosition);
        }

        return $card->setInPosition($newPosition);
    }

    private function shiftCardsUp(Card $currentCard, int $oldPosition, int $newPosition): bool
    {
        try {
            DB::transaction(function () use ($currentCard, $oldPosition, $newPosition) {
                $cards = Card::where('position', '>', $oldPosition)
                    ->where('position', '<=', $newPosition)
                    ->where('column_id', $currentCard->column_id)
                    ->get();

                foreach($cards as $card) {
                    $card->shiftUp();
                }
            });

            return true;
        } catch (Throwable) {
            return false;
        }
    }

    private function shiftCardsDown(Card $currentCard, int $oldPosition, int $newPosition): bool
    {
        try {
            DB::transaction(function () use ($currentCard, $oldPosition, $newPosition) {
                $cards = Card::where('position', '<', $oldPosition)
                    ->where('position', '>=', $newPosition)
                    ->where('column_id', $currentCard->column_id)
                    ->get();

                foreach($cards as $card) {
                    $card->shiftDown();
                }
            });

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
