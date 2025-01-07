<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogRequestAndResponse
{
    private function recordLog(Request $request, Response $response)
    {
        $requestData = $request->all();

        $log = [
            'ip_address' => $request->ip(),
            'requested_url' => $request->fullUrl(),
            'request_method' => $request->method(),
            'request_headers' => ($request->headers->all()),
            'request_body' => ($requestData),
            'response_status' => $response->getStatusCode(),
            'response_headers' => ($response->headers->all()),
            'response_body' => $response->getContent(),
        ];

        $message = implode(' -> ', array: [
            $request->ip(),
            $request->method().' '.$request->fullUrl(),
            $response->getStatusCode(),
        ]);

        if ($response->getStatusCode() >= 400) {
            Log::channel('rss')->warning($message, $log);

            return;
        }

        Log::channel('rss')->info($message, $log);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $this->recordLog($request, $response);

        return $response;
    }
}
