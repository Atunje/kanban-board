<?php

namespace App\Http\Middleware;

use App\Traits\HandlesResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AccessTokenMiddleware
{
    use HandlesResponse;

    private string $access_token = "1234567890";

    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        if ($request->string('access_token') == $this->access_token) {
            return $next($request);
        }

        return $this->jsonResponse(statusCode: HttpResponse::HTTP_UNAUTHORIZED, message: __('auth.unauthorized'));
    }
}
