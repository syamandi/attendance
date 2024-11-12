<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Attendance</title>
  <link rel="stylesheet" href="/assets/css/sidebar.css" />
  <link rel="stylesheet" href="/assets/fonts/googlefonts.css" />
  <link rel="stylesheet" href="/assets/css/bootstrap-5.3.css" />
  <link rel="stylesheet" href="/assets/font-awesome-6.6/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/daterangepicker.css" />
    <link rel="stylesheet" href="assets/css/toastr.css" />
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-header">
    <img src="/assets/img/margret-logo.svg" alt="logo" />
    <h2>Attendance</h2>
  </div>
  <ul class="sidebar-links">
    <h4>
      <div class="menu-separator"></div>
    </h4>
    <li>
      <a href="/" class="{{ request()->routeIs('index.form') ? 'active' : '' }}">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="link-text">Dashboard</span>
      </a>
    </li>
    <li>
      <a href="{{ route('attendance.form') }}" class="{{ request()->routeIs('attendance.form') ? 'active' : '' }}">
        <span class="material-symbols-outlined">person_check</span>
        <span class="link-text">Get Attendance</span>
      </a>
    </li>
    <li>
      <a href="{{ route('students') }}" class="{{ request()->routeIs('students') ? 'active' : '' }}">
        <span class="material-symbols-outlined">groups</span>
        <span class="link-text">Students</span>
      </a>
    </li>
    <li>
      <a href="{{ route('classes') }}" class="{{ request()->routeIs('classes') ? 'active' : '' }}">
        <span class="material-symbols-outlined">slab_serif</span>
        <span class="link-text">Classes</span>
      </a>
    </li>
    <li class="reports-dropdown">
  <a href="#" class="dropdown">
    <span class="material-symbols-outlined">insert_chart</span>
    <span class="link-text">Reports</span>
  </a>
  <ul class="reports-submenu">
    <li>
      <a href="{{ route('attendance.report.student') }}" class="{{ request()->routeIs('attendance.report.student') ? 'active' : '' }}">
        <span class="material-symbols-outlined">person</span>
        <span class="link-text">By Student</span>
      </a>
    </li>
    <li>
      <a href="{{ route('attendance.report.class') }}" class="{{ request()->routeIs('attendance.report.class') ? 'active' : '' }}">
        <span class="material-symbols-outlined">class</span>
        <span class="link-text">By Class</span>
      </a>
    </li>
  </ul>
</li>
<li>
      <a href="{{ route('manualattendance.form') }}" class="{{ request()->routeIs('manualattendance.form') ? 'active' : '' }}">
        <span class="material-symbols-outlined">person_check</span>
        <span class="link-text">Append Attendance</span>
      </a>
    </li>
  </ul>
</aside>

<div class="content-wrapper">
  <div class="content">
    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/jquery.js"></script>
    <script src="/assets/js/moment.js"></script>
    <script src="/assets/js/daterangepicker.js"></script>
    <script src="/assets/js/toastr.js"></script>
    @yield('content')
  </div>
</div>
</body>
</html>
