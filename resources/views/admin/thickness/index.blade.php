@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Thickness Options List</h3>
        <a href="{{ route('admin.thickness.create') }}" class="btn btn-primary btn-custom-add">
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
                            <th scope="col" style="width: 50px; background-color: #f1f5f9;">SN.</th>
                            <th scope="col" style="width: 250px; background-color: #f1f5f9;">Thickness (mm)</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Material Gropup</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Material Type</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($thicknesses as $thickness)
                        <tr>
                            <td>{{ $loop->iteration + ($thicknesses->currentPage() - 1) * $thicknesses->perPage() }}
                            </td>
                            <td>{{$thickness->thickness_value}}</td>
                            <td>{{ $thickness->materialGroup->name ?? '—' }}</td>
                            <td>{{ $thickness->materialType->name ?? '—' }}</td>
                            <td>
                                @if ($thickness->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.thickness.show', $thickness->id) }}"
                                    class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.thickness.edit', $thickness->id) }}"
                                    class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.thickness.destroy', $thickness->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this thickness?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $thicknesses->links('pagination::bootstrap-5') }}
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