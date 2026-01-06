<?php

namespace App\Http\Requests\Api\Trip;

use Illuminate\Foundation\Http\FormRequest;

class RequestTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'passenger_id' => 'required|uuid',
            'origin_lat' => 'required|numeric|min:-90|max:90',
            'origin_lng' => 'required|numeric|min:-180|max:180',
            'dest_lat' => 'required|numeric|min:-90|max:90',
            'dest_lng' => 'required|numeric|min:-180|max:180',
        ];
    }
}
