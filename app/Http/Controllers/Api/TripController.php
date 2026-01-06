<?php

namespace App\Http\Controllers\Api;

use App\Application\Trip\DTOs\RequestTripDTO;
use App\Application\Trip\UseCases\RequestTripUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function __construct(
        private RequestTripUseCase $requestTripUseCase
    ) {
    }

    public function request(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'passenger_id' => 'required|uuid',
            'origin_lat' => 'required|numeric|min:-90|max:90',
            'origin_lng' => 'required|numeric|min:-180|max:180',
            'dest_lat' => 'required|numeric|min:-90|max:90',
            'dest_lng' => 'required|numeric|min:-180|max:180',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
