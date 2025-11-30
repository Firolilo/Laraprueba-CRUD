<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FirmsDataService;
use Illuminate\Http\Request;

class FiresController extends Controller
{
    /**
     * Get fire data directly from NASA FIRMS CSV API.
     * 
     * Query params:
     * - product (optional): FIRMS product, default: VIIRS_NOAA20_NRT
     * - country (optional): ISO3 country code, default: BOL
     * - days (optional): Number of days (1-10), default: 1
     * 
     * @param Request $request
     * @param FirmsDataService $firms
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, FirmsDataService $firms)
    {
        $product = $request->query('product', 'VIIRS_NOAA20_NRT');
        $country = $request->query('country', 'BOL');
        $days = (int) $request->query('days', 1);

        // Validate days range
        $days = max(1, min(10, $days));

        $result = $firms->getFireData($product, $country, $days);

        return response()->json($result, $result['status'] ?? 200);
    }
}
