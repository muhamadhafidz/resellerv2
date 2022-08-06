<!DOCTYPE html>
<html lang="zxx">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Title Tag  -->
    <title>Out Controll</title>
	<!-- Favicon -->
	<link rel="icon" type="image/png" href="images/favicon.png">
    <!--     Fonts and icons     -->
    @include('user.includes.font')
    <!-- CSS Files -->
    @stack('before-style')
    @include('user.includes.style')
    @stack('after-style')

</head>
<body class="js">
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
    <!-- Header -->
    <header class="header shop">
        @include('user.includes.topbar')
        @include('user.includes.middlebar')
    </header>
    
    @yield('content')
    @include('user.includes.footer')

    @stack('before-script')
    @include('user.includes.script')
    @stack('after-script')
    @include('sweetalert::alert')
</body>

</html>
