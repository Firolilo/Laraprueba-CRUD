<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FirmsDataService
{
    protected ?string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.firms.key');
    }

    /**
     * Fetch fire data directly from NASA FIRMS CSV API.
     * Uses country-based endpoint with 10-minute cache.
     * 
     * @param string $product Default: VIIRS_NOAA20_NRT
     * @param string $country ISO3 country code, default: BOL
     * @param int $days Number of days (1-10)
     * @return array Array of fire objects with lat, lng, date, confidence
     */
    public function getFireData(string $product = 'VIIRS_NOAA20_NRT', string $country = 'BOL', int $days = 1): array
    {
        if (!$this->apiKey || trim($this->apiKey) === '') {
            return [
                'ok' => false,
                'status' => 401,
                'data' => [],
                'error' => 'Missing FIRMS_API_KEY. Set it in .env.',
            ];
        }

        // Cache key for this specific request
        $cacheKey = "firms_fires_{$product}_{$country}_{$days}";
        
        // Check cache (10 minutes)
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return [
                'ok' => true,
                'status' => 200,
                'data' => $cached,
                'count' => count($cached),
                'cached' => true,
            ];
        }

        try {
            $url = sprintf(
                'https://firms.modaps.eosdis.nasa.gov/api/country/csv/%s/%s/%s/%d',
                $this->apiKey,
                $product,
                $country,
                $days
            );

            $response = Http::timeout(20)
                ->retry(2, 500)
                ->withHeaders(['User-Agent' => 'SIPII-Laravel/1.0'])
                ->get($url);

            if (!$response->ok()) {
                return [
                    'ok' => false,
                    'status' => $response->status(),
                    'data' => [],
                    'error' => 'Failed to fetch fire data from FIRMS API',
                ];
            }

            $csv = $response->body();
            $fires = $this->parseCsv($csv);

            // Cache for 10 minutes
            Cache::put($cacheKey, $fires, now()->addMinutes(10));

            return [
                'ok' => true,
                'status' => 200,
                'data' => $fires,
                'count' => count($fires),
                'cached' => false,
            ];
        } catch (\Exception $e) {
            return [
                'ok' => false,
                'status' => 500,
                'data' => [],
                'error' => 'Error fetching FIRMS fire data: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Parse CSV string into array of fire objects.
     * Expected CSV format: header row, then data rows with at least:
     * - column 1: latitude
     * - column 2: longitude
     * - column 6: date (optional)
     * - column 10: confidence (optional)
     * 
     * @param string $csv
     * @return array
     */
    protected function parseCsv(string $csv): array
    {
        $lines = array_filter(array_map('trim', explode("\n", trim($csv))));
        
        if (count($lines) < 2) {
            return []; // No data rows
        }

        // Skip header (first line)
        $headers = array_shift($lines);
        
        $fires = [];
        foreach ($lines as $lineNumber => $line) {
            if (empty($line)) {
                continue;
            }

            $data = str_getcsv($line);

            // Verify minimum columns (at least lat, lng)
            if (count($data) < 3) {
                continue;
            }

            $lat = isset($data[1]) ? (float) $data[1] : null;
            $lng = isset($data[2]) ? (float) $data[2] : null;

            // Only add if coordinates are valid
            if ($lat !== null && $lng !== null && !is_nan($lat) && !is_nan($lng)) {
                $fires[] = [
                    'lat' => $lat,
                    'lng' => $lng,
                    'date' => $data[6] ?? 'Fecha desconocida',
                    'confidence' => $data[10] ?? null,
                ];
            }
        }

        return $fires;
    }
}
