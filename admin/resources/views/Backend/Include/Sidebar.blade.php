 <style>
    .section-divider{
        display:flex; align-items:center; gap:12px; margin:16px 0;
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
        font-weight:700; text-transform:uppercase; letter-spacing:.08em; font-size:.85rem; color:#ffffff;
    }
    body.dark-mode .section-divider::before,
    body.dark-mode .section-divider::after{ background:linear-gradient(to right, transparent, rgba(253, 253, 253, 0.25)); }
    body.dark-mode .section-divider span{ color:#ffffff; }
</style>


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        
        <img src="{{ asset('Backend/img/default-logo.png') }}" alt="Default Logo" class="brand-image elevation-3">
        




    </a>
    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('Backend/images/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
       
      </div>

      



        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Dashboard -->
               <li class="nav-item ">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link  {{ $route == 'admin.dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
            </ul>
        </nav>
<!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>
