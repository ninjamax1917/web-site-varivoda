<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ViewSession;

class MediaMtxAuthController extends Controller
{
    // MediaMTX -> POST /api/mediamtx/auth with JSON body
    public function __invoke(Request $request)
    {
        $data = $request->json()->all();

        $action = $data['action'] ?? '';
        $path = $data['path'] ?? '';
        $protocol = $data['protocol'] ?? '';
        $queryString = $data['query'] ?? '';

        // Разрешаем только чтение (read)
        if ($action !== 'read') {
            return response('', 403);
        }

        // Разбор query (?exp=...&token=...)
        parse_str($queryString, $q);
        $exp = isset($q['exp']) ? (int) $q['exp'] : 0;
        $token = $q['token'] ?? '';
        $uid = $q['uid'] ?? null; // optional user id

        if ($exp <= time()) {
            return response('', 401);
        }

        $secret = env('STREAM_TOKEN_SECRET', config('app.key'));
        $payload = $action . '|' . $path . '|' . $exp;
        $expected = hash_hmac('sha256', $payload, $secret);

        if (!hash_equals($expected, (string) $token)) {
            return response('', 401);
        }

        // Если передан uid — проверим блокировку и отметим сессию
        if ($uid) {
            $user = User::find($uid);
            if ($user && ($user->stream_blocked ?? false)) {
                return response('', 403);
            }

            if ($user) {
                // ожидаем path вида cam{id}
                $cameraId = (int) Str::of($path)->after('cam')->toString();
                if ($cameraId > 0) {
                    ViewSession::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'camera_id' => $cameraId,
                            'protocol' => $protocol,
                            // агрегируем в пределах суток, чтобы не плодить строки
                            'started_at' => now()->startOfDay(),
                        ],
                        [
                            'last_seen_at' => now(),
                            'ip' => $request->ip(),
                            'ua' => substr((string) $request->userAgent(), 0, 255),
                        ]
                    );
                }
            }
        }

        // OK — разрешаем
        return response('', 204);
    }
}
