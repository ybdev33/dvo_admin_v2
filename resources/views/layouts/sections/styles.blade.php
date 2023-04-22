<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/fonts-googleapi.css') }}" />

<link rel="stylesheet" href="{{ asset(mix('assets/vendor/fonts/boxicons.css')) }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/core.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/theme-default.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('assets/css/demo.css')) }}" />

<link rel="stylesheet" href="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')) }}" />

@if((new \Jenssegers\Agent\Agent())->isMobile())
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.min.css') }}" />
@endif

<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')
