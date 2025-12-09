@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="fw-bold mb-0">Cutout Material Thickness Prices</h3>
        <a href="{{ route('admin.cutout.material.thickness.price.controller.create') }}" class="btn btn-primary btn-custom-add">
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
                            <th style="width: 200px; background-color: #f1f5f9;">Cut Outs</th>                           
                            <th style="width: 200px; background-color: #f1f5f9;">Thickness Value</th>                           
                            <th style="width: 150px; background-color: #f1f5f9;">Guest Price</th>
                            <th style="width: 150px; background-color: #f1f5f9;">Business Price</th>
                            <th style="width: 120px; background-color: #f1f5f9;">Status</th>
                            <th style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cutout_material_thickness as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->materialType->name ?? '—' }}</td>
                            <td>{{ $list->cutOuts->name ?? '—' }}</td>                            
                            <td>{{ $list->thickness_value }}</td>                           
                            <td>{{ number_format($list->price_guest, 2) }}</td>
                            <td>{{ number_format($list->price_business, 2) }}</td>
                            <td>
                                @if ($list->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.cutout.material.thickness.price.controller.edit', $list->id) }}"
                                   class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>    
                                <form action="{{ route('admin.cutout.material.thickness.price.controller.destroy', $list->id) }}" method="POST"
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
                    {{ $cutout_material_thickness->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
