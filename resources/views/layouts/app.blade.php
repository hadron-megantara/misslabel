<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="shortcut icon" type="image/png" href="/img/icon/icon.png"/>
    <!-- Styles -->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/jquery-ui.min.css" rel="stylesheet">

    <!-- BEGIN PLUGIN CSS -->
    <link href="/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/bootstrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- END PLUGIN CSS -->
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="/css/webarch.css" rel="stylesheet" type="text/css" />
    <!-- END CORE CSS FRAMEWORK -->

    <script src="/js/jquery-1.11.2.min.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    
    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        @include('includes.header')
        @yield('content')
    </div>

    @include('includes.footer')

    <!-- BEGIN CORE JS FRAMEWORK-->
    <script src="/plugins/pace/pace.min.js" type="text/javascript"></script>
    <!-- BEGIN JS DEPENDECENCIES-->
    <script src="/plugins/jquery/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="/plugins/bootstrapv3/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/plugins/jquery-block-ui/jqueryblockui.min.js" type="text/javascript"></script>
    <script src="/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
    <script src="/plugins/jquery-scrollbar/jquery.scrollbar.min.js" type="text/javascript"></script>
    <script src="/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
    <script src="/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
    <script src="/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
    <!-- END CORE JS DEPENDECENCIES-->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="/js/webarch.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
</body>
</html>
