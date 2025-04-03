<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeolocationController extends Controller
{
    public function storeGeolocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];

        return response()->json(['message' => 'Geolocation data received successfully', 'latitude' => $latitude, 'longitude' => $longitude]);
    }
}
