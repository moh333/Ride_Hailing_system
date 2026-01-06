<?php

namespace App\Http\Controllers\Api;

use App\Application\Passenger\DTOs\RegisterPassengerDTO;
use App\Application\Passenger\UseCases\RegisterPassengerUseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PassengerController extends Controller
{
    public function __construct(
        private RegisterPassengerUseCase $registerPassengerUseCase
    ) {
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255', // Unique check done in UseCase or here? UseCase does it.
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

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
