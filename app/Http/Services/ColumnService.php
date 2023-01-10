<?php

namespace App\Http\Services;

use DB;
use App\Models\Column;
use App\Http\Resources\ColumnResource;
use Throwable;

class ColumnService {

    public function create(array $data): ColumnResource
    {
        $column = Column::create($data);
        return new ColumnResource($column);
    }

    public function getAll(): mixed
    {
        return ColumnResource::collection(Column::getAll())->resource;
    }

    public function delete(Column $column): bool
    {
        try {
            DB::transaction(function () use ($column) {
                //delete cards
                $column->cards()->delete();
                //now delete card
                $column->delete();
            });

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
