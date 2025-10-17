<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block"><a href="" class="nav-link">Home</a>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->
            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">

                    @php
                    $image = auth('admin')->user()->image;
                    $logoPath = $image
                    ? asset('storage/' . $image)
                    : asset('assets/img/logo-def.png');
                    @endphp

                    <img src="{{ $logoPath }}" class="user-image rounded-circle shadow" alt="User Image" />
                    <span class="d-none d-md-inline">{{ Auth::guard('admin')->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-dark">
                       
                        @php
                        $image = auth('admin')->user()->image;
                        $logoPath = $image
                        ? asset('storage/' . $image)
                        : asset('assets/img/logo-def.png');
                        @endphp

                        <img src="{{ $logoPath }}" class="rounded-circle shadow" alt="User Logo" />
                        <p>{{ Auth::guard('admin')->user()->name }}
                            <small>Email:- {{ Auth::guard('admin')->user()->email }}</small>
                        </p>
                    </li>
                    <!--end::User Image-->

                    <!--begin::Menu Footer-->
                    <li class="user-footer d-flex justify-content-between">
                        <form action="{{ route('admin.profile') }}" method="GET">
                            <button type="submit" class="btn btn-primary btn-sm">Profile</button>

                        </form>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                            style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left:132px;">Sign
                                out</button>
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>