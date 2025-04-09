<?php

namespace App\Http\Middleware;

use Closure;
use Corcel\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class RestrictSiteAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access if referer header exists
        if ($request->headers->get('referer') || session('Referer')) {
            return $next($request);
        }
        // Retrieve the URI and extract the encoded data
        $uri = $request->getRequestUri();
        $data = null;
        if (strpos($uri, 'pd/') !== false) {
            $data = explode('pd/', $uri)[1] ?? null;
        } elseif (strpos($uri, 'patient-details/') !== false) {
            $data = explode('patient-details/', $uri)[1] ?? null;
        }

        // Remove "=" character only from the end of $data
        $data = rtrim($data, '=');

        // Decode and validate Base64 data
        $decodedData = base64_decode($data, true);
        if ($decodedData === false) {
            return redirect('/unauthorized')->with('error', 'Invalid data format.');
        }

        // Process decoded data
        $dataParts = explode(',', $decodedData);


        try {
            if (count($dataParts) >= 3) {
                // Validate email existence
                $email = $dataParts[0] ?? '';
                if (!empty($email)) {
                    return $next($request);
                }
            } elseif (count($dataParts) == 2) {
                // Fetch email based on user_id
                $userId = $dataParts[0] ?? '';

                $user = User::findOrFail($userId);
                if (!empty($user)) {
                    return $next($request);
                }
            }
        } catch (\Exception $e) {
            // Log error for debugging purposes
            Log::error('Middleware error: ' . $e->getMessage());
        }

        // Redirect if access is restricted
        return redirect('/unauthorized')->with('error', 'Access restricted.');
    }
}
