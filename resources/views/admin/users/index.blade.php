@extends('layouts.app')

@section('title', 'Пользователи — трансляции')

@section('content')
    <div class="max-w-6xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Пользователи</h1>

        @if (session('status'))
            <div class="alert alert-success mb-4">{{ session('status') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Сегодня</th>
                        <th>Всего</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $s = $stats[$user->id] ?? ['today_seconds' => 0, 'total_seconds' => 0];
                            $fmt = fn($sec) => sprintf(
                                '%02d:%02d:%02d',
                                intdiv($sec, 3600),
                                intdiv($sec % 3600, 60),
                                $sec % 60,
                            );
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $fmt($s['today_seconds']) }}</td>
                            <td>{{ $fmt($s['total_seconds']) }}</td>
                            <td>
                                @if ($user->stream_blocked)
                                    <span class="badge badge-error">заблокирован</span>
                                @else
                                    <span class="badge badge-success">доступен</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                    @csrf
                                    <button class="btn btn-sm">
                                        @if ($user->stream_blocked)
                                            Разблокировать
                                        @else
                                            Заблокировать
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
