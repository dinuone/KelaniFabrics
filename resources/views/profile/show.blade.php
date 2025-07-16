@extends('layout.app')

@section('title', 'Profile')

@section('content')
<div class="card mt-4">
    <div class="card-header">
        <h3>User Profile</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4"><strong>Name:</strong></div>
            <div class="col-md-8">{{ $user->first_name . " " . $user->last_name}}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Email:</strong></div>
            <div class="col-md-8">{{ $user->email }}</div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Role:</strong></div>
            <div class="col-md-8">
                @if($user->roles->isNotEmpty())
                    @foreach ($user->roles as $role)
                        <span class="badge bg-success">{{ $role->name }}</span>
                    @endforeach
                @else
                    <span class="text-muted">No role assigned</span>
                @endif
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Created At:</strong></div>
            <div class="col-md-8">{{ $user->created_at->format('Y-m-d') }}</div>
        </div>
    </div>
</div>
@endsection
