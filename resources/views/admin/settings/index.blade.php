@extends('admin.layouts.app')
@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Website Settings</h3>

    @include('admin.layouts.alerts')

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf

        <div class="table-responsive">
            <table class="table table-bordered" id="settings-table">
                <thead class="table-light">
                    <tr>
                        <th style="width: 250px;">Key</th>
                        <th style="width: 250px;">Value</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $key => $value)
                        <tr>
                            <td><input type="text" name="settings[keys][]" value="{{ $key }}" class="form-control" required readonly></td>
                            <td><input type="text" name="settings[values][]" value="{{ $value }}" class="form-control" required></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td><input type="text" name="settings[keys][]" class="form-control" placeholder="Enter key" required></td>
                            <td><input type="text" name="settings[values][]" class="form-control" placeholder="Enter value" required></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row" disabled>&times;</button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <button type="button" id="add-row-btn" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle"></i> Add More
            </button>

            <button type="submit" class="btn btn-success">Save Settings</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('add-row-btn').addEventListener('click', function () {
        const tableBody = document.querySelector('#settings-table tbody');
        const newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td><input type="text" name="settings[keys][]" class="form-control" placeholder="Enter key" required></td>
            <td><input type="text" name="settings[values][]" class="form-control" placeholder="Enter value" required></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm remove-row">&times;</button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@if(session('success') || session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        });
    </script>
@endif
@endpush