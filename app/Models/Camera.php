<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    protected $fillable = [
        'name',
        'rtsp_url',
        'preview',
        'views_today',
        'views_online',
        'views_total',
    ];

    public function signedHlsUrl(int $ttlSeconds = 300, ?int $userId = null): string
    {
        $path = 'cam' . $this->id;
        $exp = time() + $ttlSeconds;
        $secret = env('STREAM_TOKEN_SECRET', config('app.key'));
        $payload = 'read|' . $path . '|' . $exp;
        $token = hash_hmac('sha256', $payload, $secret);

        $base = env('MEDIAMTX_HLS_BASE', 'http://host.docker.internal:8888');
        $qs = http_build_query(array_filter(['exp' => $exp, 'token' => $token, 'uid' => $userId]));
        return rtrim($base, '/') . '/' . $path . '/index.m3u8?' . $qs;
    }

    public function signedWhepUrl(int $ttlSeconds = 300, ?int $userId = null): string
    {
        $path = 'cam' . $this->id;
        $exp = time() + $ttlSeconds;
        $secret = env('STREAM_TOKEN_SECRET', config('app.key'));
        $payload = 'read|' . $path . '|' . $exp;
        $token = hash_hmac('sha256', $payload, $secret);

        $base = env('MEDIAMTX_WHEP_BASE', 'http://localhost:8889');
        $qs = http_build_query(array_filter(['exp' => $exp, 'token' => $token, 'uid' => $userId]));
        return rtrim($base, '/') . '/' . $path . '/whep?' . $qs;
    }
}
