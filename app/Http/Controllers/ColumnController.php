<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Illuminate\Http\JsonResponse;
use App\Http\Services\ColumnService;
use App\Http\Requests\StoreColumnRequest;
use Symfony\Component\HttpFoundation\Response;

class ColumnController extends Controller
{
    public function __construct(private ColumnService $columnService)
    {
        //
    }

    public function index(): JsonResponse
    {
        $columns = $this->columnService->getAll();
        return $this->jsonResponse(data: $columns, message: __('columns.all_fetched'), data_wrapper: 'columns');
    }

    public function store(StoreColumnRequest $request): JsonResponse
    {
        $column = $this->columnService->create($request->validFields());
        return $this->jsonResponse(data: $column, message: __('columns.created'));
    }

    public function destroy(Column $column): JsonResponse
    {
        if ($this->columnService->delete($column)) {
            return $this->jsonResponse(message: __('columns.deleted'));
        }

        return $this->jsonResponse(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: __('columns.could_not_delete')
        );
    }

    public function update(Column $column, StoreColumnRequest $request): JsonResponse
    {
        if ($this->columnService->update($column, $request->validFields())) {
            return $this->jsonResponse(message: __('columns.updated'));
        }

        return $this->jsonResponse(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: __('columns.could_not_delete')
        );
    }
}
