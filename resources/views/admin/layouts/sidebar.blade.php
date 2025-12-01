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

                {{-- Material Management --}}
                <li class="nav-item has-treeview {{ request()->is('admin/material*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/material*') ? 'active' : '' }}">
                        <i class="nav-icon bi-box-seam"></i>
                        <p>
                            Material Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.material.group.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.group.list') ? 'active' : '' }}">
                                <i class="bi-diagram-3 nav-icon"></i>
                                <p>Material Groups</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.material.type.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.type.list') ? 'active' : '' }}">
                                <i class="bi-layers nav-icon"></i>
                                <p>Material Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.color.list') }}"
                                class="nav-link {{ request()->routeIs('admin.color.list') ? 'active' : '' }}">
                                <i class="bi-palette nav-icon text-red"></i>
                                <p class="text-red">Materials / Colors</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.finish.list') }}"
                                class="nav-link {{ request()->routeIs('admin.finish.list') ? 'active' : '' }}">
                                <i class="bi-brush nav-icon text-orange"></i>
                                <p class="text-orange">Material Finishes</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.thickness.list') }}"
                                class="nav-link {{ request()->routeIs('admin.thickness.list') ? 'active' : '' }}">
                                <i class="bi-arrows-expand nav-icon text-blue"></i>
                                <p class="text-blue">Thickness Options</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Layout Configuration --}}
                <li class="nav-item has-treeview {{ request()->is('admin/material-layout*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/material-layout*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-columns-gap"></i>
                        <p>
                            Layout Configuration
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- Category List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.material.layout.category.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.layout.category.list') ? 'active' : '' }}">
                                <i class="bi bi-tags nav-icon"></i>
                                <p>Layout Categories</p>
                            </a>
                        </li>
                        {{-- Material Layout List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.material.layout.group.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.layout.group.list') ? 'active' : '' }} ">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Layout Groups</p>
                            </a>
                        </li>

                        {{-- Material Layout Shape --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.material.layout.shape.list') }}"
                                class="nav-link {{ request()->routeIs('admin.material.layout.shape.list') ? 'active' : '' }}">
                                <i class="bi bi-layout-text-sidebar nav-icon"></i>
                                <p>Layout Shapes</p>
                            </a>
                        </li>
                    </ul>
                </li>               

                {{-- Edge Management --}}
                <li class="nav-item has-treeview {{ request()->is('admin/edge-profile*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/edge-profile*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-diagram-3"></i>
                        <p>
                            Edge Management
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- Category List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.edge.profile.list') }}"
                                class="nav-link {{ request()->routeIs('admin.edge.profile.list') ? 'active' : '' }}">
                                <i class="bi bi-tags nav-icon"></i>
                                <p>Edge Profiles</p>
                            </a>
                        </li>    
                        {{-- Edge Profile Thickness Rules --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.edge.profile.thickness.list') }}"
                                class="nav-link {{ request()->routeIs('admin.edge.profile.thickness.list') ? 'active' : '' }}">
                                <i class="bi bi-journal-text nav-icon"></i>
                                <p>Edge Profile Rules</p>
                            </a>
                        </li>     
                        {{-- Material Color Edge Exceptions --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.color.edge.exception.list') }}"
                                class="nav-link {{ request()->routeIs('admin.color.edge.exception.list') ? 'active' : '' }}">
                                <i class="bi bi-exclamation-triangle nav-icon"></i>
                                <p>Edge Pricing</p>
                            </a>
                        </li>               
                    </ul>
                </li>

                {{-- Backsplash Management --}}
                <li class="nav-item has-treeview {{ request()->is('admin/backsplash-shapes*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/backsplash-shapes*') ? 'active' : '' }}">
                       <i class="nav-icon bi bi-view-stacked"></i>

                        <p>
                            Backsplash
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.backsplash.shapes.list') }}"
                                class="nav-link {{ request()->routeIs('admin.backsplash.shapes.list') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-bounding-box-circles"></i>
                                <p>Backsplash Shapes</p>
                            </a>
                        </li>            
                    </ul>
                     <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.backsplash.shapes.sides.list') }}"
                                class="nav-link {{ request()->routeIs('admin.backsplash.shapes.sides.list') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-arrows-fullscreen"></i>
                                <p>Shape Sides</p>
                            </a>
                        </li>            
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.backsplash.price.list') }}"
                                class="nav-link {{ request()->routeIs('admin.backsplash.price.list') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-cash-stack"></i>
                                <p>Backsplash Pricing</p>
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
                        {{-- Category List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.sink.category.list') }}"
                                class="nav-link {{ request()->routeIs('admin.sink.category.list') ? 'active' : '' }}">
                                <i class="bi bi-tags nav-icon"></i>
                                <p>Category List</p>
                            </a>
                        </li>
                        {{-- Sink List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.sink.list') }}"
                                class="nav-link {{ request()->routeIs('admin.sink.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Sink List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Cut Outs Menu --}}
                <li class="nav-item has-treeview {{ request()->is('admin/cut-outs*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('admin/cut-outs*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-scissors"></i>
                        <p>
                            Cut Outs
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        {{-- Cut Outs Category List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.cutouts.category.list') }}"
                                class="nav-link {{ request()->routeIs('admin.cutouts.category.list') ? 'active' : '' }}">
                                <i class="bi bi-tags nav-icon"></i>
                                <p>Category List</p>
                            </a>
                        </li>
                        {{-- Cut Outs List --}}
                        <li class="nav-item">
                            <a href="{{ route('admin.cut.outs.list') }}"
                                class="nav-link {{ request()->routeIs('admin.cut.outs.list') ? 'active' : '' }}">
                                <i class="bi bi-list-ul nav-icon"></i>
                                <p>Cut Outs List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Promo Code Menu --}}
                <li class="nav-item">
                    <a href="{{ route('admin.promo.code.list') }}"
                        class="nav-link {{ request()->routeIs('admin.promo.code.list') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-ticket-perforated"></i>
                        <p>Promo Code</p>
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