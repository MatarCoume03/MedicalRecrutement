@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h1>Mes Notifications</h1>
        </div>
        <div class="col-md-6 text-right">
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    Tout marquer comme lu
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($notifications->isEmpty())
                <p class="text-center">Vous n'avez aucune notification.</p>
            @else
                <div class="list-group">
                    @foreach($notifications as $notification)
                        <a href="#" class="list-group-item list-group-item-action {{ $notification->is_read ? '' : 'list-group-item-primary' }} notification-item"
                           data-id="{{ $notification->id }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">{{ $notification->type }}</h5>
                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">{{ $notification->message }}</p>
                            @if(!$notification->is_read)
                                <span class="badge badge-primary">Nouveau</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.notification-item').click(function(e) {
        e.preventDefault();
        const notificationId = $(this).data('id');
        
        // Marquer comme lue via AJAX
        $.ajax({
            url: `/notifications/${notificationId}/mark-as-read`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                window.location.href = $(e.currentTarget).attr('href');
            }
        });
    });
});
</script>
@endsection