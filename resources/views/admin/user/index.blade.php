@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">User List</h3>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form class="row g-3 mb-3" method="GET" action="{{ route('admin.user.list') }}">
                <div class="col-md-3">
                    <label for="name" class="form-label"><b>Name:</b></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ request('name') }}"
                        placeholder="Enter name">
                </div>
                <div class="col-md-3">
                    <label for="mobile" class="form-label"><b>Mobile:</b></label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ request('mobile') }}"
                        placeholder="Enter mobile">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Search</button>
                    <a href="{{ route('admin.user.list') }}" class="btn btn-danger">Reset</a>
                </div>
            </form>
            @include('admin.layouts.alerts')
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" style="width: 50px; background-color: #f1f5f9;">SN.</th>
                            <th scope="col" style="width: 150px; background-color: #f1f5f9;">Name</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Email</th>
                            <th scope="col" style="width: 100px; background-color: #f1f5f9;">Mobile</th>
                            <th scope="col" style="width: 100px; background-color: #f1f5f9;">Photo</th>
                            <th scope="col" style="width: 100px; background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>
                                <img src="{{ asset($user->photo ? 'uploads/users/' . $user->photo : 'uploads/users/user.png') }}"
                                    alt="Profile Photo" width="60" height="60"
                                    style="border-radius: 5px; object-fit: cover;">
                            </td>
                            <td>
                                @if ($user->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.user.view', $user->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i>
                                        Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
@if(session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
});
</script>
@endif
@endsection