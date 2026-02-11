@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container">
    <h3>Notifications</h3>

    <ul class="list-group">
        @forelse($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center
                {{ $notification->read_at ? '' : 'fw-bold bg-light' }}">

                <a href="{{ route('notifications.read', $notification->id) }}">
                    {{ $notification->data['message'] ?? 'New notification' }}
                </a>

                @if(!$notification->read_at)
                    <span class="badge bg-primary">New</span>
                @else
                    <span class="badge bg-secondary">Read {{ $notification->read_at->diffForHumans() }}</span>
                @endif
            </li>
        @empty
            <li class="list-group-item">No notifications</li>
        @endforelse
    </ul>
</div>
@endsection
