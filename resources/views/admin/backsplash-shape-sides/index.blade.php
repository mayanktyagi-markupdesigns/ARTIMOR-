@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Backsplash Shapes Sides List</h3>
        <a href="{{ route('admin.backsplash.shapes.sides.create') }}" class="btn btn-primary btn-custom-add">
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
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">SN.</th>
                            <th scope="col" style="width: 250px; background-color: #f1f5f9;">Shape Name</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Side Name</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Label</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Finishable</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Sort Order</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($sides as $side)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $side->backsplashShape->name ?? '—' }}</td>
                            <td>{{ $side->side_name }}</td>
                            <td>{{ $side->label ?? '—' }}</td>
                            <td>{{ $side->is_finishable ? 'Yes' : 'No' }}</td>
                            <td>{{ $side->sort_order }}</td>
                            <td>
                                @if($side->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.backsplash.shapes.sides.edit',$side->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.backsplash.shapes.sides.destroy',$side->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $sides->links('pagination::bootstrap-5') }}
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