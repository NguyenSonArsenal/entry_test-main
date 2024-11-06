@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('notification_error'))
    <div class="alert alert-danger">
        {{ session('notification_error') }}
    </div>
@endif
