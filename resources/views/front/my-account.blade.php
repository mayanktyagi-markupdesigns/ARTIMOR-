@extends('front.layouts.app')
@section('content')
<style>
    /* --- Layout Container --- */
    .account-container {
        display: flex;
        max-width: 100%;
        margin: 80px auto;
        background-color: #fff;
        min-height: 565px;
    }

    /* --- Sidebar Styling --- */
    .sidebar {
        width: 200px;
        border-right: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* User Info in Sidebar */
    .user-info {
        text-align: left;
        padding-bottom: 20px;
    }

    .profile-image-sidebar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        display: block;
    }

    .user-name {
        font-size: 15px;
        line-height: 1;
        font-weight: 300;
        color: #000;
        margin-bottom: 12px;
    }

    .user-email {
        font-size: 15px;
        line-height: 1;
        color: #000;
        font-weight: 500;
    }

    /* Sidebar Navigation */
    .sidebar-nav ul {
        list-style: none;
        padding: 0;
    }

    .sidebar-nav li {
        margin-bottom: 25px;
    }

    .sidebar-nav a {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #000;
        font-size: 15px;
        font-weight: 300;
        transition: color 0.2s;
    }

    .sidebar-nav a:hover,
    .sidebar-nav .active a {
        color: #000;
        font-weight: 500;
    }

    .sidebar-nav a i {
        margin-right: 5px;
    }

    /* --- Main Content Styling --- */
    .main-content {
        flex-grow: 1;
        padding: 0 0 0 60px;
        max-width: 730px;
    }

    /* Account Header */
    .account-header h1 {
        font-size: 18px;
        line-height: 25px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .account-header p {
        font-size: 15px;
        color: #666;
        margin-bottom: 30px;
    }

    .account-header hr {
        border: none;
        border-top: 1px solid #000;
        margin: 0 0 30px 0;
    }

    /* Profile Section */
    .profile-section h2 {
        font-size: 18px;
        line-height: 25px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* Profile Image Upload */
    .profile-image-upload {
        display: flex;
        flex-direction: column;
        align-items: start;
        margin-bottom: 40px;
    }

    .profile-image-main {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 20px;
    }

    .replace-image-link {
        color: #000;
        text-decoration: none;
        font-size: 0.9em;
    }

    /* --- Form Styling --- */
    .profile-form {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .form-row {
        display: flex;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .form-group.full-width {
        flex: none;
    }

    label {
        font-size: 16px;
        font-weight: 400;
        color: #848484;
        margin-bottom: -11px;
        max-width: fit-content;
        background: #fff;
        position: relative;
        z-index: 1;
        margin-left: 10px;
        padding: 0 5px;
    }

    .required {
        color: #dc3545;
        margin-left: 2px;
    }

    input[type="text"],
    input[type="email"] {
        padding: 10px 15px;
        font-size: 16px;
        line-height: 1px;
        font-weight: 300;
        border: 1px solid #ABABAB;
        min-height: 60px;
        border-radius: 10px;
        outline: none;
        width: 100%;
        font-style: normal;
    }

    input::placeholder {
        color: rgba(132, 132, 132, 0.5);
        font-style: italic;
    }

    input:focus {
        border-color: #000;
        box-shadow: 0 0 0 0.1rem rgba(0, 0, 0, 0.25);
    }

    .file-upload {
        position: relative;
    }

    .file-upload span {
        text-decoration: underline;
        opacity: 80%;
        font-size: 16px;
        margin-top: 5px;
        display: block;
    }

    .file-upload input {
        position: absolute;
        width: 100%;
        top: 0;
        opacity: 0;
    }

    /* --- Button Styling (Update Profile) --- */
    .form-actions {
        margin-top: 10px;
    }

    .btn-primary {
        font-size: 17px;
        line-height: 1;
        font-weight: 400;
        padding: 20px 52px !important;
    }

    .btn-primary:before {
        right: -4px;
        top: 12px;
    }

    .btn-primary:after {
        right: -12px;
        bottom: -5px;
    }

    @media screen and (max-width: 767px) {
        .profile-image-sidebar {
            width: 60px;
            height: 60px;
            margin: 0 auto 10px;
        }

        .account-header p {
            margin-bottom: 15px;
        }

        .account-header hr {
            margin: 0 0 15px 0;
        }

        .sidebar-nav ul {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .account-container {
            flex-direction: column;
            margin: 35px auto;
        }

        .form-row {
            flex-direction: column;
        }

        .file-upload span {
            font-size: 15px;
        }

        input[type="text"],
        input[type="email"] {
            min-height: 50px;
        }

        .main-content {
            padding: 0;
        }

        .sidebar {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
            gap: 0;
        }

        .user-info {
            text-align: center;
            padding-bottom: 20px;
        }

        .sidebar-nav li {
            margin-bottom: 0;
        }

        .account-header {
            margin-top: 20px;
        }

    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>
@endif

<!-- Steps Section -->
<div class="main-pg">
    <div class="container">
        <div class="account-container">
            <div class="sidebar">
                <div class="user-info">
                    <img src="{{ Auth::user()->photo ? asset('uploads/users/'.Auth::user()->photo) : asset('assets/front/img/default-profile.png') }}" 
                         alt="Profile Picture" class="profile-image-sidebar">
                    <p class="user-name">{{ Auth::user()->name }}</p>
                    <p class="user-email">{{ Auth::user()->email }}</p>
                </div>
                <div class="sidebar-nav">
                    <ul>
                        <li class="active"><a href="#"><i class="fa-regular fa-user"></i> <span>My Account</span></a></li>
                        <li><a href="#"><i class="fa-regular fa-comments"></i> <span>Choose Language</span></a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" style="all:unset; cursor:pointer; display:flex; align-items:center;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> <span style="margin-left:5px;">Logout</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content">
                <div class="account-header">
                    <h1>Account</h1>
                    <p>Manage your profile and customize settings.</p>
                    <hr>
                </div>

                <div class="profile-section">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                        @csrf
                        <h2>Profile</h2>
                        <div class="profile-image-upload">
                            <img src="{{ Auth::user()->photo ? asset('uploads/users/'.Auth::user()->photo) : asset('assets/front/img/default-profile.png') }}" 
                                 alt="Profile Picture" class="profile-image-main">
                            <div class="file-upload">
                                <span>Replace Image</span>
                                <input type="file" name="photo" />
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Name<span class="required">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile<span class="required">*</span></label>
                                <input type="text" id="mobile" name="mobile" value="{{ old('mobile', Auth::user()->mobile) }}">
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="email">Email ID<span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}">
                        </div>
                        <div class="form-actions">
                            <button class="btn btn-dark btn-primary" type="submit">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>

@endsection