 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="custhome" class="brand-link">
      <img src="{{asset('vendors/dist/img/MediaoneLogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CUSTOMER PAGE

      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="custProfile" class="d-block"></a> 

        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

       <!-- Sidebar Menu -->
       <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                 <li class="nav-item">
                     <a href="custProfile" class="nav-link">
                         <i class="nav-icon fas fa-tachometer-alt"></i>
                         <p> Profile </p>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a href="custhome" class="nav-link">
                         <i class="nav-icon fas fa-paw"></i>
                         <p> Pets </p>
                     </a>
                 </li>
                 <!-- Sidebar Menu -->
                 <nav class="mt-2">
                     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                         <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                         <li class="nav-item">
                             <a href="custAcc" class="nav-link">
                                 <i class="nav-icon fas fa-user"></i>
                                 <p> Account Settings </p>
                             </a>
                         </li>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <br>
                         <li class="nav-item">
                             <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                             <form action="{{ route('user.logout') }}" method="post" class="d-none" id="logout-form">@csrf</form>
                                 <i class="nav-icon fas fa-sign-out-alt "></i>
                                 <p> Logout </p>
                             </a>
                         </li>
                     </ul>
                 </nav>
                 <!-- /.sidebar-menu -->
     </div>
     <!-- /.sidebar -->
 </aside>