<?php

namespace App\Http\Controllers\Api;

use App\Application\Driver\DTOs\RegisterDriverDTO;
use App\Application\Driver\UseCases\RegisterDriverUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function __construct(
        private RegisterDriverUseCase $registerDriverUseCase
    ) {
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
            'license_plate' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
                'id' => $id
            ], 201);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }
}
