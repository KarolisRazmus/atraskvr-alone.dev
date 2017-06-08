<!DOCTYPE html>
<html>
<head>
    @include('admin.includes.meta')

    <title>@yield('title')</title>

    @include('admin.includes.css')

</head>

<body class="hold-transition skin-purple sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

    @include('admin.includes.header')

    <!-- =============================================== -->

    @include('admin.includes.aside')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @yield('content')

    </div>
    <!-- /.content-wrapper -->

    @include('admin.includes.footer')

</div>
<!-- ./wrapper -->

@include('admin.includes.js')

</body>
</html>
