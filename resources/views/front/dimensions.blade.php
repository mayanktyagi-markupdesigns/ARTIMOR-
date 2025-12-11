@php
// Initialize dimensions with default values if not set
$dimensions = session('dimensions', ['blad1' => ['width' => '', 'height' => '']]);
$blad1 = isset($dimensions['blad1']) ? $dimensions['blad1'] : ['width' => '', 'height' => ''];
@endphp
<div class="materials">
    <div class="row">
        <div class="col-lg-12 mt-5 mb-5 Blad-01">
            <div class="measurement-cl">
                <div class="hori-mas-box mb-5 d-flex align-items-center justify-content-center">
                    <div class="hornumber">
                        <input type="text" class="form-control width-input" id="width1" placeholder="Width (cm)" value="{{ $blad1['width'] }}">
                    </div>
                </div>
                <div class="prod-box-bottom d-flex align-items-center justify-content-between gap-5">
                    <div class="prod-box-mid d-flex align-items-center justify-content-center position-relative">
                        <span class="left-ci-01 dotline"></span>
                        Blad 01
                        <span class="right-ci-01 dotline"></span>
                        <span class="right-ci-02 dotline btmdot"></span>
                    </div>
                    <div class="prod-box-rht">
                        <div class="inpnumber">
                            <input type="text" class="form-control height-input" id="height1" placeholder="Height (cm)" value="{{ $blad1['height'] }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.measurement-cl input.form-control {
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 8px;
    width: 100px;
    text-align: center;
}
.measurement-cl input.form-control:invalid,
.measurement-cl input.form-control.is-invalid {
    border-color: #dc3545;
}
.measurement-cl input.form-control.is-valid {
    border-color: #28a745;
}
.measurement-cl .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>