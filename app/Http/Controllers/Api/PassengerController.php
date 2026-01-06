<?php

namespace App\Http\Controllers\Api;

use App\Application\Passenger\DTOs\RegisterPassengerDTO;
use App\Application\Passenger\UseCases\RegisterPassengerUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Passenger\RegisterPassengerRequest;
use Illuminate\Http\JsonResponse;

class PassengerController extends Controller
{
    public function __construct(
        private RegisterPassengerUseCase $registerPassengerUseCase
    ) {
    }

    public function register(RegisterPassengerRequest $request): JsonResponse
    {
        $dto = new RegisterPassengerDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        try {
            $id = $this->registerPassengerUseCase->execute($dto);
            return response()->json([
                'message' => 'Passenger registered successfully',
                'id' => $id
            ], 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400); // Bad Request for logical errors
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
