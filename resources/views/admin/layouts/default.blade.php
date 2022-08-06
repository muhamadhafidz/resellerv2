<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Navil Store Admin</title>
  <link rel="icon" type="image/png" href="">
    <!--     Fonts and icons     -->
    @include('admin.includes.font')
    <!-- CSS Files -->
    @stack('before-style')
    @include('admin.includes.style')
    @stack('after-style')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    
      <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="" alt="AdminLTELogo" height="100" width="100">
        </div>
        @include('admin.includes.navbar')
        {{-- sidebar --}}
        @include('admin.includes.sidebar')
        {{-- end sidebar --}}

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            </div>
            <!-- /.content-header -->
            <section class="content">
            @yield('content')
            </section>
            <!-- End Navbar -->
        </div>

            {{-- @include('admin.includes.footer') --}}
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

</body>
@stack('before-script')
@include('admin.includes.script')
@stack('after-script')
@include('sweetalert::alert')

</html>
