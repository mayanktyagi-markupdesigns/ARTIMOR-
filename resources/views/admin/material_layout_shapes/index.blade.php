@extends('admin.layouts.app')

@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Material Layout Shape</h3>       
            <a href="{{ route('admin.material.layout.shape.create') }}"  class="btn btn-primary btn-custom-add">
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
                            <th scope="col" style="width: 250px; background-color: #f1f5f9;">Name</th>
                            <th scope="col" style="width: 250px; background-color: #f1f5f9;">Layout Group</th>
                            <th scope="col" style="width: 150px; background-color: #f1f5f9;">Image</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shape as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->name }}</td>
                            <td>{{ $list->layoutGroup->name ?? '—' }}</td>
                            <td>
                                @if($list->image)
                                <img src="{{ asset('uploads/layout-shapes/' . $list->image) }}" alt="material Image"
                                    width="80">
                                @else
                                <span class="text-muted">No image</span>
                                @endif
                            </td>                            
                            <td>
                                @if ($list->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            
                            <td>                                
                                <a href="{{ route('admin.material.layout.shape.edit', $list->id) }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.material.layout.shape.destroy', $list->id) }}" method="POST"
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
                    {{ $shape->links('pagination::bootstrap-5') }}
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