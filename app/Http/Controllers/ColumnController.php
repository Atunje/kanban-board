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

    /**
     * @OA\Get(
     *      path="/api/columns",
     *      operationId="columns",
     *      tags={"Columns"},
     *      summary="Get all columns",
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function index(): JsonResponse
    {
        $columns = $this->columnService->getAll();
        return $this->jsonResponse(data: $columns, message: __('columns.all_fetched'), data_wrapper: 'columns');
    }

    /**
     * @OA\Post(
     *      path="/api/columns",
     *      operationId="createColumn",
     *      tags={"Columns"},
     *      summary="Create a new column",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={
     *                      "title"
     *                  },
     *                  @OA\Property(property="title", type="string")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreColumnRequest $request): JsonResponse
    {
        $column = $this->columnService->create($request->validFields());
        return $this->jsonResponse(data: $column, message: __('columns.created'));
    }

    /**
     * @OA\Delete(
     *      path="/api/columns/{id}",
     *      operationId="deleteColumn",
     *      tags={"Columns"},
     *      summary="Delete column",
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
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
}
