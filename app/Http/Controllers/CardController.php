<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCardToColumnRequest;
use App\Http\Requests\CardShiftRequest;
use App\Http\Requests\ShiftCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use App\Http\Services\CardService;
use App\Http\Requests\CardListRequest;
use App\Http\Requests\StoreCardRequest;
use Symfony\Component\HttpFoundation\Response;

class CardController extends Controller
{
    public function __construct(private CardService $cardService)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/list-cards",
     *      operationId="cards",
     *      tags={"Cards"},
     *      summary="Get all columns",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  @OA\Property(property="date", type="string"),
     *                  @OA\Property(property="status", type="integer"),
     *                  @OA\Property(property="access_token", type="string"),
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function listing(CardListRequest $request): JsonResponse
    {
        $cards = $this->cardService->listCards($request->validFields());
        return $this->jsonResponse(data: $cards, message: __('cards.all_fetched'), data_wrapper: 'cards');
    }

    /**
     * @OA\Post(
     *      path="/api/cards",
     *      operationId="createCard",
     *      tags={"Cards"},
     *      summary="Create a new column",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={
     *                      "title",
     *                      "description",
     *                      "column_id",
     *                      "position"
     *                  },
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="string"),
     *                  @OA\Property(property="column_id", type="integer")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function store(StoreCardRequest $request): JsonResponse
    {
        $column = $this->cardService->create($request->validFields());
        return $this->jsonResponse(data: $column, message: __('cards.created'));
    }

    /**
     * @OA\Put(
     *      path="/api/cards/{id}",
     *      operationId="updateCard",
     *      tags={"Cards"},
     *      summary="Update card",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={
     *                      "title",
     *                      "description",
     *                      "column_id"
     *                  },
     *                  @OA\Property(property="title", type="string"),
     *                  @OA\Property(property="description", type="description"),
     *                  @OA\Property(property="column_id", type="integer")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function update(Card $card, UpdateCardRequest $request): JsonResponse
    {
        if ($this->cardService->update($card, $request->validFields())) {
            return $this->jsonResponse(message: __('cards.updated'));
        }

        return $this->jsonResponse(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: __('cards.could_not_update')
        );
    }

    /**
     * @OA\Patch(
     *      path="/api/cards/{id}/shift",
     *      operationId="updateCard",
     *      tags={"Cards"},
     *      summary="Update card",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={
     *                      "new_position",
     *                  },
     *                  @OA\Property(property="old_position", type="integer"),
     *                  @OA\Property(property="new_position", type="integer")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function shift(Card $card, CardShiftRequest $request): JsonResponse
    {
        //return $request->all();

        if ($this->cardService->shiftCard($card, $request->integer('new_position'))) {
            return $this->jsonResponse(message: __('cards.updated'));
        }

        return $this->jsonResponse(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: __('cards.could_not_update')
        );
    }

    /**
     * @OA\Patch(
     *      path="/api/cards/{id}/add-to-column",
     *      operationId="updateCard",
     *      tags={"Cards"},
     *      summary="Update card",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={
     *                      "column_id",
     *                      "position",
     *                  },
     *                  @OA\Property(property="column_id", type="integer"),
     *                  @OA\Property(property="position", type="integer")
     *              )
     *          )
     *      ),
     *      @OA\Response(response=200, description="OK"),
     *      @OA\Response(response=401, description="Unauthorized"),
     *      @OA\Response(response=422, description="Unprocessable Entity"),
     *      @OA\Response(response=500, description="Internal Server Error")
     * )
     */
    public function addToColumn(Card $card, AddCardToColumnRequest $request): JsonResponse
    {
        if ($this->cardService->addCard(
            $card, $request->integer('column_id'), $request->integer('position'))
        ) {
            return $this->jsonResponse(message: __('cards.updated'));
        }

        return $this->jsonResponse(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            message: __('cards.could_not_update')
        );
    }
}
