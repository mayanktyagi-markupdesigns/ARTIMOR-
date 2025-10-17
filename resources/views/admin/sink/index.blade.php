@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Sink List</h3>       
        <a href="{{ route('admin.sink.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
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
                            <th style="width: 250px; background-color: #f1f5f9;">Name</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Series Type</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Internal Dim.</th>
                            <th style="width: 200px; background-color: #f1f5f9;">External Dim.</th>
                            <th style="width: 100px; background-color: #f1f5f9;">Status</th>
                            <th style="width: 250px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sink as $item)
                        <tr>
                            <td>{{ $loop->iteration + ($sink->currentPage()-1)*$sink->perPage() }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->series_type }}</td>
                            <td>{{ $item->internal_dimensions ?? '-' }}</td>
                            <td>{{ $item->external_dimensions ?? '-' }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.sink.view', $item->id) }}" class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i> View
                                </a>
                                <a href="{{ route('admin.sink.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.sink.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">No sinks found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $sink->links('pagination::bootstrap-5') }}
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
