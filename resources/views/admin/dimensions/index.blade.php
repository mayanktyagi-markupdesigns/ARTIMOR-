@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Dimension List</h3>
        <a href="{{ route('admin.dimension.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">ID</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Image</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Height (cm)</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Width (cm)</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dimensions as $dim)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($dim->image)
                                <img src="{{ asset('uploads/dimensions/' . $dim->image) }}" width="80"
                                    alt="Dimension Image" />
                                @else
                                N/A
                                @endif
                            </td>
                            <td>{{ $dim->height_cm }}</td>
                            <td>{{ $dim->width_cm }}</td>
                            <td>{{ $dim->status ? 'Active' : 'Inactive' }}</td>                           
                            <td>                               
                                <a href="{{ route('admin.dimension.edit', $dim->id) }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.dimension.destroy', $dim->id) }}" method="POST"
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
                    {{ $dimensions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@if(session('success') || session('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('statusModal'));
    modal.show();
});
</script>
@endif
@endsection