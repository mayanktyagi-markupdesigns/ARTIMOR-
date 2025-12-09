@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Backsplash Shapes List</h3>
        <a href="{{ route('admin.backsplash.price.create') }}" class="btn btn-primary btn-custom-add">
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
                            <th scope="col" style="width: 250px; background-color: #f1f5f9;">Material Type</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Price LM (Guest)</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Finished Side Price (Guest)</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Price LM (Business)</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Finished Side Price (Business)</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Min Height (mm)</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Max Height</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th>                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prices as $price)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $price->materialType->name ?? '—' }}</td>
                            <td>{{ $price->price_lm_guest }}</td>
                            <td>{{ $price->finished_side_price_lm_guest }}</td>
                            <td>{{ $price->price_lm_business }}</td>
                            <td>{{ $price->finished_side_price_lm_business }}</td>
                            <td>{{ $price->min_height_mm ?? '—' }}</td>
                            <td>{{ $price->max_height_mm ?? '—' }}</td>
                            <td>
                                @if($price->status)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.backsplash.price.edit', $price->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.backsplash.price.destroy', $price->id) }}" method="POST"
                                    class="d-inline-block">
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
                    {{ $prices->links('pagination::bootstrap-5') }}
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