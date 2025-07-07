@extends('layout.app')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('css')
<style>
    .role-form {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        max-width: 700px;
        margin: 0 auto;
    }
    .form-header {
        color: #2c3e50;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
        font-size: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        color: #4a5568;
        display: block;
        margin-bottom: 0.5rem;
    }
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        width: 100%;
    }
    .permissions-list {
        columns: 2;
        -webkit-columns: 2;
        -moz-columns: 2;
        margin-top: 1rem;
    }
    .permissions-list label {
        display: block;
        margin-bottom: 0.3rem;
        font-size: 0.95rem;
    }
    .submit-btn {
        background: #4299e1;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: none;
        margin-top: 2rem;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .submit-btn:hover {
        background: #3182ce;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="role-form">
        <h2 class="form-header">{{ isset($role) ? 'Edit Role' : 'Create New Role' }}</h2>

        <form method="POST" action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}">
            @csrf
            @if(isset($role))
                @method('PATCH')  
            @endif

            <div class="form-group">
                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $role->name ?? '') }}" required>
                @error('name')
                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Assign Permissions</label>
                <div class="permissions-list">
                    @foreach($permissions as $permission)
                        <label>
                            <input type="checkbox" name="permissions[]"
                                   value="{{ $permission->id }}"
                                   {{ isset($role) && $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                            {{ $permission->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="form-footer text-end">
                <button type="submit" class="submit-btn">
                    {{ isset($role) ? 'Update Role' : 'Create Role' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
