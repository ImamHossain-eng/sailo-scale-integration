@extends('layouts.super-admin.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Roles Management</h2>
        <a href="{{ route('super-admin.roles.create') }}" class="btn btn-primary"><i class="bi bi-shield-plus me-1"></i> Add Role</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->description ? \Illuminate\Support\Str::limit($role->description, 50) : '-' }}</td>
                            <td>{{ $role->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('super-admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('super-admin.roles.destroy', $role) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $roles->links() }}
        </div>
    </div>
@endsection