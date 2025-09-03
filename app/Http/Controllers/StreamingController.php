<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Camera;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ViewSession;

class StreamingController extends Controller
{
    public function index()
    {
        $cameras = \App\Models\Camera::all();

        $statuses = [];

        // Hosts can be configured via MEDIAMTX_HOSTS (comma-separated list).
        // Example: MEDIAMTX_HOSTS="http://host.docker.internal:9997/v3/paths/list,http://172.17.0.1:9997/v3/paths/list"
        $hosts = explode(',', env('MEDIAMTX_HOSTS', 'http://host.docker.internal:9997/v3/paths/list,http://172.17.0.1:9997/v3/paths/list,http://10.10.0.141:9997/v3/paths/list,http://localhost:9997/v3/paths/list'));

        // Optional Basic Auth credentials for MediaMTX API
        $username = env('MEDIAMTX_USER');
        $password = env('MEDIAMTX_PASS');
        $debug = filter_var(env('MEDIAMTX_DEBUG', false), FILTER_VALIDATE_BOOL);

        $json = null;
        foreach ($hosts as $url) {
            $url = trim($url);
            if (empty($url)) {
                continue;
            }

            try {
                // Use basic auth if credentials provided
                if (!empty($username)) {
                    $client = Http::withBasicAuth($username, $password)->timeout(3);
                } else {
                    $client = Http::timeout(3);
                }

                $response = $client->get($url);
                if ($debug) {
                    Log::info('mediamtx request url: ' . $url . ' status: ' . $response->status());
                    Log::info('mediamtx headers: ' . json_encode($response->headers()));
                }
                $body = $response->body();
                if ($debug) {
                    Log::info('mediamtx body (len=' . strlen($body) . '): ' . substr($body, 0, 1000));
                }

                if ($response->ok() && !empty($body)) {
                    $json = $body;
                    break;
                }
            } catch (\Throwable $e) {
                Log::warning('mediamtx request to ' . $url . ' failed: ' . $e->getMessage());
            }
        }

        if ($json) {
            $data = json_decode($json, true);
            foreach ($data['items'] ?? [] as $info) {
                $statuses[$info['name']] = $info['ready'] ?? false;
            }
        } else {
            Log::warning('mediamtx: no json response from any host');
        }

        // Соберём статистику просмотров по камерам
        $now = now();
        $activeWindow = (int) env('VIEWERS_ACTIVE_WINDOW', 45); // секунд
        $activeWindow = max(10, min($activeWindow, 300)); // гвардrails
        $activeThreshold = $now->copy()->subSeconds($activeWindow);

        $active = ViewSession::selectRaw('camera_id, COUNT(DISTINCT user_id) as cnt')
            ->where('last_seen_at', '>=', $activeThreshold)
            ->groupBy('camera_id')
            ->pluck('cnt', 'camera_id');

        $today = ViewSession::selectRaw('camera_id, COUNT(*) as cnt')
            ->whereDate('started_at', $now->toDateString())
            ->groupBy('camera_id')
            ->pluck('cnt', 'camera_id');

        $total = ViewSession::selectRaw('camera_id, COUNT(*) as cnt')
            ->groupBy('camera_id')
            ->pluck('cnt', 'camera_id');

        $viewStats = [];
        foreach ($cameras as $cam) {
            $viewStats[$cam->id] = [
                'now' => (int) ($active[$cam->id] ?? 0),
                'today' => (int) ($today[$cam->id] ?? 0),
                'total' => (int) ($total[$cam->id] ?? 0),
            ];
        }

        return view('streaming.cctv_city', compact('cameras', 'statuses', 'viewStats'));
    }
}
