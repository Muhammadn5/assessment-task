<?php

namespace App\Http\Controllers;

use App\Services\AffiliateService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WebhookController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * Pass the necessary data to the process order method
     * 
     * @param  Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request, OrderService $orderService): JsonResponse
    {
        // TODO: Complete this method
        $orderService->processOrder($request->all());
        return response()->json(['message' => 'Webhook processed successfully'], Response::HTTP_OK);
    }
}