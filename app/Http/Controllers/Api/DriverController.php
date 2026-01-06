<?php

namespace App\Http\Controllers\Api;

use App\Application\Driver\DTOs\RegisterDriverDTO;
use App\Application\Driver\UseCases\RegisterDriverUseCase;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Driver\RegisterDriverRequest;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    public function __construct(
        private RegisterDriverUseCase $registerDriverUseCase
    ) {
    }

    public function register(RegisterDriverRequest $request): JsonResponse
    {
        $dto = new RegisterDriverDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('password'),
            $request->input('license_plate')
        );

        try {
            $id = $this->registerDriverUseCase->execute($dto);
            return response()->json([
                'message' => 'Driver registered successfully',
                'data' => $id
            ], 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
