<?php

namespace App\Http\Controllers;

use App\Traits\HandlesResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Kanban Board API - Swagger Documentation",
 *      description="",
 *      @OA\Contact(
 *          email="nobelatunje001@gmail.com"
 *      ),
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, HandlesResponse;
}
