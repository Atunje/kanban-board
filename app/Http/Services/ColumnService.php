<?php

namespace App\Http\Services;

use App\Http\Resources\ColumnResource;
use App\Models\Column;
use DB;

class ColumnService {

    public function create(array $data): ColumnResource
    {
        $column = Column::create($data);
        return new ColumnResource($column);
    }

    public function getAll(): mixed
    {
        return ColumnResource::collection(Column::all())->resource;
    }

    public function delete(Column $column): bool|null
    {
        return $column->delete();
    }

    public function update(Column $column, array $data): bool
    {
        return $column->update($data);
    }
}
