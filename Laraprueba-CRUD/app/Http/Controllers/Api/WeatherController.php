<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OpenMeteoService;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    /**
     * Get weather data (current or historical).
     * 
     * Query params:
     * - latitude (required)
     * - longitude (required)
     * - start_date (optional, YYYY-MM-DD for historical)
     * - end_date (optional, YYYY-MM-DD for historical)
     * 
     * @param Request $request
     * @param OpenMeteoService $weather
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, OpenMeteoService $weather)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        ]);

        $latitude = (float) $request->query('latitude');
        $longitude = (float) $request->query('longitude');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $result = $weather->getWeatherData($latitude, $longitude, $startDate, $endDate);

        return response()->json($result, $result['status'] ?? 200);
    }
}
