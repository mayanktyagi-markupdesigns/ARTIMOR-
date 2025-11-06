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

                {{-- Material --}}
                <li class="nav-item has-treeview {{ request()->is('admin/material*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/material*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Material
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.material.list') }}"
                                class="nav-link {{ request()->routeIs('material.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Material List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.material.create') }}"
                                class="nav-link {{ request()->routeIs('material.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add Material</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Material Type --}}
                <li class="nav-item has-treeview {{ request()->is('admin/material-type*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/material-type*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>
                            Material Type
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.material.type.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.type.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Material Type List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.material.type.create') }}"
                                class="nav-link {{ request()->routeIs('admin.material.type.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add Material Type</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Material Layout --}}
                <li class="nav-item has-treeview {{ request()->is('admin/material-layout*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/material-layout*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-columns-gap"></i>
                        <p>
                            Material Layout
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.layout.list') }}"
                                class="nav-link {{ request()->routeIs('admin.layout.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Material Layout List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.layout.create') }}"
                                class="nav-link {{ request()->routeIs('admin.layout.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add Material Layout</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Material Edge Menu -->
                <li class="nav-item has-treeview {{ request()->is('admin/material-edge*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/material-edge*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Material Edge
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.material.edge.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.edge.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.material.edge.create') }}"
                                class="nav-link {{ request()->routeIs('admin.material.edge.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Back Wall Menu -->
                <li class="nav-item has-treeview {{ request()->is('admin/back-wall*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/back-wall*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-door-open"></i>
                        <p>
                            Back Wall
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.back.wall.list') }}"
                                class="nav-link {{ request()->routeIs('admin.back.wall.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.back.wall.create') }}"
                                class="nav-link {{ request()->routeIs('admin.back.wall.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Sink Menu --}}
                <li class="nav-item has-treeview {{ request()->is('admin/sink*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/sink*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-droplet-half"></i>
                        <p>
                            Sink
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.sink.list') }}"
                                class="nav-link {{ request()->routeIs('admin.sink.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Sink List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.sink.create') }}"
                                class="nav-link {{ request()->routeIs('admin.sink.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add Sink</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Cut Outs Menu -->
                <li class="nav-item has-treeview {{ request()->is('admin/cut-outs*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/cut-outs*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-scissors"></i>
                        <p>
                            Cut Outs
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.cut.outs.list') }}"
                                class="nav-link {{ request()->routeIs('admin.cut.outs.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.cut.outs.create') }}"
                                class="nav-link {{ request()->routeIs('admin.cut.outs.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                   <!-- Promo Code Menu -->
                <li class="nav-item has-treeview {{ request()->is('admin/promo-code*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/promo-code*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-ticket-perforated"></i>
                        <p>
                            Promo Code
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.promo.code.list') }}"
                                class="nav-link {{ request()->routeIs('admin.promo.code.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.promo.code.create') }}"
                                class="nav-link {{ request()->routeIs('admin.promo.code.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Quotation Menu -->
                <li class="nav-item has-treeview {{ request()->is('admin/quotation*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/quotation*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>
                            Quotations
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.quotations.list') }}"
                                class="nav-link {{ request()->routeIs('admin.quotations.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Quotation List</p>
                            </a>
                        </li>                        
                    </ul>
                </li>

                {{-- User Management --}}
                <li class="nav-item has-treeview {{ request()->is('admin/user*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.list') }}"
                                class="nav-link {{ request()->routeIs('admin.user.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user.create') }}"
                                class="nav-link {{ request()->routeIs('admin.user.create') ? 'active' : '' }}">
                                <i class="bi bi-plus-square nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Settings --}}
                <li class="nav-item has-treeview {{ request()->is('admin/settings*') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.settings.edit') }}"
                        class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Settings</p>
                    </a>
                </li>

                {{-- Auth Section --}}
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