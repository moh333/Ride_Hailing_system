<?php

namespace App\Http\Controllers\Api;

use App\Application\Trip\DTOs\RequestTripDTO;
use App\Application\Trip\UseCases\RequestTripUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Trip\RequestTripRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TripController extends Controller
{
    public function __construct(
        private RequestTripUseCase $requestTripUseCase
    ) {
    }

    public function request(RequestTripRequest $request): JsonResponse
    {
        // Validation is automatically handled by RequestTripRequest

        $dto = new RequestTripDTO(
            $request->input('passenger_id'),
            (float) $request->input('origin_lat'),
            (float) $request->input('origin_lng'),
            (float) $request->input('dest_lat'),
            (float) $request->input('dest_lng')
        );

        try {
            $tripId = $this->requestTripUseCase->execute($dto);
            return response()->json([
                'message' => 'Trip requested successfully',
                'trip_id' => $tripId
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
