<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AudioProxyController extends Controller
{
    /**
     * Stream a remote audio file through the app so the browser can access it
     * without CORS restrictions. Only direct audio file URLs are allowed.
     */
    public function stream(Request $request)
    {
        $url = $request->query('url') ?? $request->input('url');
        if (empty($url)) {
            return response()->json(['error' => 'Missing url parameter'], 400);
        }

        // Basic validation: require http/https
        $parts = parse_url($url);
        if (!isset($parts['scheme']) || !in_array(strtolower($parts['scheme']), ['http', 'https'])) {
            return response()->json(['error' => 'Only http/https URLs are supported'], 400);
        }

        // Prevent proxying obviously blocked services (YouTube/Spotify) to avoid encouraging ToS violations
        if (preg_match('/(youtube\.com|youtu\.be|spotify\.com|spotify:)/i', $url)) {
            return response()->json(['error' => 'Proxying YouTube/Spotify streams is not supported. Use direct audio file URLs.'], 422);
        }

        $client = new Client(['timeout' => 15, 'allow_redirects' => true, 'headers' => ['User-Agent' => 'QuantumAudioProxy/1.0']]);

        try {
            // Try a HEAD request first to inspect content-type
            try {
                $head = $client->request('HEAD', $url);
            } catch (\Exception $e) {
                // Some servers don't respond to HEAD; fall back to a short GET
                $head = $client->request('GET', $url, ['headers' => ['Range' => 'bytes=0-1023']]);
            }

            $ctype = $head->getHeaderLine('Content-Type');
            if ($ctype === '') {
                $ctype = 'application/octet-stream';
            }

            // Allow if content-type is audio/* OR url has common audio extension
            if (!str_starts_with($ctype, 'audio/') && !preg_match('/\.(mp3|wav|ogg|m4a|aac|flac)(\?|$)/i', $url)) {
                return response()->json(['error' => 'URL does not appear to be a direct audio file. Proxy supports direct audio URLs only.'], 422);
            }

            // Stream the GET response
            $res = $client->request('GET', $url, ['stream' => true]);
            $status = $res->getStatusCode();
            $contentType = $res->getHeaderLine('Content-Type') ?: 'application/octet-stream';
            $contentLength = $res->getHeaderLine('Content-Length');

            $body = $res->getBody();

            return response()->stream(function () use ($body) {
                while (! $body->eof()) {
                    echo $body->read(1024 * 8);
                    flush();
                }
            }, $status, array_filter([
                'Content-Type' => $contentType,
                'Content-Length' => $contentLength ?: null,
            ]));

        } catch (\Exception $e) {
            Log::warning('Audio proxy error: ' . $e->getMessage(), ['url' => $url]);
            return response()->json(['error' => 'Failed to fetch remote audio: ' . $e->getMessage()], 422);
        }
    }
}
