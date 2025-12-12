@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="fw-bold mb-0">Material Color Edge Exception List</h3>

        <a href="{{ route('admin.color.edge.exception.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i> Add New
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @include('admin.layouts.alerts')
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="text-uppercase">
                        <tr>
                            <th style="width: 50px; background-color: #f1f5f9;">SN.</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Material Type</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Material Color</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Edge Profile</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Thickness</th>
                            <!-- <th style="width: 150px; background-color: #f1f5f9;">Is Allowed</th> -->
                            <th style="width: 120px; background-color: #f1f5f9;">Status</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($color_edge_exception as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->materialType->name ?? '—' }}</td>
                            <td>{{ $list->color->name ?? '—' }}</td>
                            <td>{{ $list->edgeProfile->name ?? '—' }}</td>
                            <td>{{ $list->thickness->thickness_value ?? '—' }}</td>
                            <!-- <td>
                                @if($list->is_allowed == 'true')
                                    <span class="badge bg-success">Allowed</span>
                                @else
                                    <span class="badge bg-danger">Not Allowed</span>
                                @endif
                            </td> -->
                            <td>
                                @if ($list->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.color.edge.exception.edit', $list->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>    
                                <form action="{{ route('admin.color.edge.exception.destroy', $list->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $color_edge_exception->links('pagination::bootstrap-5') }}
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
