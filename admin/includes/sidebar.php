<!-- Sidebar -->
<ul class="navbar-nav bg-main sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
      <div class="sidebar-brand-icon">
        <img class="rounded-circle logo-dashboard" src="./img/Clinic logo.png" alt="...">
      </div>
      <div class="sidebar-brand-text mx-3">Admin</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.php">
    <i class="fas fa-fw fa-tachometer-alt"></i>
    <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - Appointments -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-calendar"></i>
        <span class="font-weight-bold">Appointment</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-light py-2 collapse-inner rounded">
            <a class="collapse-item text-main border-bottom" href="app_upcoming.php">Upcoming</a>
            <a class="collapse-item text-main border-bottom" href="app_request.php">Requests</a>
            <a class="collapse-item text-main" href="app_done.php">Done</a>
        </div>
    </div>
  </li>

  <!-- Nav Item - Child Records -->
  <li class="nav-item">
    <a class="nav-link" href="list_child.php">
    <i class="fas fa-fw fa-child"></i>
    <span class="font-weight-bold">Child List</span></a>
  </li>

  <!-- Nav Item - Parent List -->
  <li class="nav-item">
    <a class="nav-link" href="list_parent.php">
    <i class="fas fa-fw fa-user"></i>
    <span class="font-weight-bold">Parent List</span></a>
  </li>

  <!-- Nav Item - Doctor List -->
  <li class="nav-item">
    <a class="nav-link" href="list_doctor.php">
    <i class="fas fa-fw fa-user-nurse"></i>
    <span class="font-weight-bold">Doctor List</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->