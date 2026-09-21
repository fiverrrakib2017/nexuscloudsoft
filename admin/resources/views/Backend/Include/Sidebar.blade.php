<style>
    .section-divider{
        display:flex; align-items:center; gap:12px; margin:16px 0 8px 0; padding: 0 12px;
    }
    .section-divider::before,
    .section-divider::after{
        content:""; height:1px; flex:1;
        background:linear-gradient(to right, transparent, rgba(255, 255, 255, 0.25));
    }
    .section-divider::after{
        background:linear-gradient(to left, transparent, rgba(255, 255, 255, 0.25));
    }
    .section-divider span{
        font-weight:700; text-transform:uppercase; letter-spacing:.08em; font-size:.72rem; color:#b8c7ce;
    }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ asset('Backend/img/default-logo.png') }}" alt="Nexus Cloud Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Nexus Cloud Soft</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Main Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt text-info"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Section Divider: WEBSITE CMS -->
                <div class="section-divider">
                    <span>Website Content</span>
                </div>

                <!-- Hero Section -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-star text-warning"></i>
                        <p>Hero Section</p>
                    </a>
                </li>

                <!-- About Us Section -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-building text-primary"></i>
                        <p>About Us Section</p>
                    </a>
                </li>

                <!-- Why Choose Us / Values -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-shield-alt text-success"></i>
                        <p>Why Choose Us</p>
                    </a>
                </li>

                <!-- Features & Solutions -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-cogs text-info"></i>
                        <p>Features & Solutions</p>
                    </a>
                </li>

                <!-- Pricing Plans -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-tags text-danger"></i>
                        <p>Pricing Packages</p>
                    </a>
                </li>

                <!-- Team Members -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-users text-light"></i>
                        <p>Team Members</p>
                    </a>
                </li>

                <!-- Contact & Footer Settings -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-address-book text-warning"></i>
                        <p>Contact & Footer</p>
                    </a>
                </li>

                <!-- Section Divider: LEADS & SYSTEM -->
                <div class="section-divider">
                    <span>Leads & Settings</span>
                </div>

                <!-- Demo Requests / Leads -->
                <li class="nav-item">
                    <a href="" class="nav-link ">
                        <i class="nav-icon fas fa-inbox text-teal"></i>
                        <p>
                            Demo Requests
                            <span class="right badge badge-danger">5 New</span>
                        </p>
                    </a>
                </li>

                <!-- General & SEO Settings -->
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-sliders-h text-secondary"></i>
                        <p>Logo & SEO Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>