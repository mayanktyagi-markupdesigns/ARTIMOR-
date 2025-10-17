@extends('admin.layouts.app')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold">Promo Code List</h3>
        <a href="{{ route('admin.promo.code.create') }}" class="btn btn-primary btn-custom-add">
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
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">code</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Discount Type</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Discount Value</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($promo as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->code }}</td>
                            <td>{{ $list->discount_type }}</td>
                            <td>{{ $list->discount_value }}</td>
                            <td>{{ $list->status ? 'Active' : 'Inactive' }}</td>                           
                            <td>                               
                                <a href="{{ route('admin.promo.code.edit', $list->id) }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-pencil"></i> Edit</a>
                                <form action="{{ route('admin.promo.code.destroy', $list->id) }}" method="POST"
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
                    {{ $promo->links('pagination::bootstrap-5') }}
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