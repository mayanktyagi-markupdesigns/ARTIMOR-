@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Master Product List</h3>
        <a href="{{ route('admin.masterproduct.create') }}" class="btn btn-primary btn-custom-add">
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
                            <th style="width: 50px; background-color: #f1f5f9;">SN.</th>
                            <th style="width: 250px; background-color: #f1f5f9;">Product Name</th>
                            <th style="width: 250px; background-color: #f1f5f9;">Material</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Material Type</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Layout</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Edge</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Back Wall</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Sink</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Cut Out</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Color</th>
                            <th style="width: 100px; background-color: #f1f5f9;">Status</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->material->name ?? '—' }}</td>
                            <td>{{ $list->materialType->name ?? '—' }}</td>
                            <td>{{ $list->materialLayout->name ?? '—' }}</td>
                            <td>{{ $list->materialEdge->name ?? '—' }}</td>
                            <td>{{ $list->backWall->name ?? '—' }}</td>
                            <td>{{ $list->sink->name ?? '—' }}</td>
                            <td>{{ $list->cutOut->name ?? '—' }}</td>
                            <td>{{ $list->color->name ?? '—' }}</td>
                            <td>
                                @if ($list->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.masterproduct.view', $list->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.masterproduct.edit', $list->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.masterproduct.destroy', $list->id) }}" method="POST" style="display:inline-block;">
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
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success') || session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('statusModal'));
        modal.show();
    });
</script>
@endif
@endsection