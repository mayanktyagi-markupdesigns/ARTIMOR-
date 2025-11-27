<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{ asset('assets/img/artimar-sologon.jpg') }}" alt="artimar Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light"></span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.material.group.list') }}"
                        class="nav-link {{ request()->routeIs('admin.material.group.list') ? 'active' : '' }}">
                        <i class="nav-icon bi-diagram-3"></i>
                        <p>Material Group</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.material.type.list') }}"
                        class="nav-link {{ request()->routeIs('admin.material.type.list') ? 'active' : '' }}">
                        <i class="nav-icon bi-layers"></i>
                        <p>Material Type</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.color.list') }}"
                        class="nav-link {{ request()->routeIs('admin.color.list') ? 'active' : '' }}">
                        <i class="nav-icon bi-palette text-red"></i>
                        <p class="text-red">Colors</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.finish.list') }}"
                        class="nav-link {{ request()->routeIs('admin.finish.list') ? 'active' : '' }}">
                        <i class="nav-icon bi-brush text-orange"></i>
                        <p class="text-orange">Finish</p>
                    </a>
                </li>

                {{-- User Management --}}
                <li class="nav-item">
                    <a href="{{ route('admin.user.list') }}"
                        class="nav-link {{ request()->routeIs('admin.user.list') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Users</p>
                    </a>
                </li>

                <!-- Settings -->
                <li class="nav-item has-treeview {{ request()->is('admin/settings*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.settings.edit') }}"
                        class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <!-- Auth Section -->
                <li
                    class="nav-item has-treeview {{ request()->is('admin/profile') || request()->is('admin/change-password') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->is('admin/profile') || request()->is('admin/change-password') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                            Auth
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.profile') }}"
                                class="nav-link {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-circle"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.password.change') }}"
                                class="nav-link {{ request()->routeIs('admin.password.change') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-key-fill"></i>
                                <p>Change Password</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.logout') }}" class="nav-link">
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</aside>