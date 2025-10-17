@if(session('success') || session('error'))
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="mb-3">
                        @if(session('success'))
                            <div class="bg-success bg-opacity-10 rounded-circle d-inline-block p-3">
                                <i class="bi bi-check-circle-fill text-success fs-1"></i>
                            </div>
                            <h4 class="text-success mt-3">Success</h4>
                            <p class="text-muted">{{ session('success') }}</p>
                        @elseif(session('error'))
                            <div class="bg-danger bg-opacity-10 rounded-circle d-inline-block p-3">
                                <i class="bi bi-x-circle-fill text-danger fs-1"></i>
                            </div>
                            <h4 class="text-danger mt-3">Error</h4>
                            <p class="text-muted">{{ session('error') }}</p>
                        @endif
                    </div>
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
