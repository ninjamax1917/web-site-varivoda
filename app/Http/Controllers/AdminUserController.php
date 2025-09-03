<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ViewSession;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        // Соберём статистику по просмотрам
        $sessions = ViewSession::select(['user_id', 'started_at', 'last_seen_at'])
            ->get()
            ->groupBy('user_id');

        $nowDate = now()->toDateString();
        $stats = [];
        foreach ($sessions as $userId => $rows) {
            $total = 0;
            $today = 0;
            foreach ($rows as $s) {
                $dur = max(0, $s->last_seen_at->diffInSeconds($s->started_at));
                $total += $dur;
                if ($s->started_at->toDateString() === $nowDate || $s->last_seen_at->toDateString() === $nowDate) {
                    $today += $dur;
                }
            }
            $stats[$userId] = [
                'total_seconds' => $total,
                'today_seconds' => $today,
            ];
        }

        return view('auth.users.index', compact('users', 'stats'));
    }

    public function toggle(User $user, Request $request)
    {
        $user->stream_blocked = !$user->stream_blocked;
        $user->save();
        return redirect()->back()->with('status', 'Обновлено');
    }
}
