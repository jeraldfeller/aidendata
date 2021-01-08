
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Aidendata.com</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->
        <link rel="shortcut icon" href="{{ url('aiden/images/favicon.ico') }}">

        <!-- stylesheets -->
        <link rel="stylesheet" type="text/css" href="{{ url('aiden/scss/bootstrap/bootstrap.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ url('aiden/dist/theme.min.css') }}" />

        <!-- javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlYNNs7VBO71qiKFMNiD0R9sd8hOt0wD4"></script>
        <script src="{{ url('aiden/dist/theme.min.js') }}"></script>
    </head>
    <body>
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!--[if lt IE 8]>
          <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!--[if lt IE 9]>
     <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
   <![endif]-->

        <!--[if lt IE 8]>
          <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent" role="navigation">
            <div class="container no-override">
                <a class="navbar-brand" href="index" style="margin-right: 0!important;">
                    <img src="{{ url('aiden/images/logo-alt-w.png') }}" class="d-none d-lg-inline mr-2 w-25" />
                    Aiden
                </a>
                <img src="{{ url('aiden/images/MIT-logo.png') }}" class="d-none d-lg-inline mr-2" style="width: 130px;">
                <button class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbar-collapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="login">
                                Sign in
                                <i class="ion-arrow-right-c"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="business-hero">
            <div class="container">
                <h2 class="customFadeInUp">
                    Identifying Real Estate Development Opportunities: Web-Scraping, Regex Patterns & String-Searching Algorithms
                </h2>
                <p class="customFadeInUp">
                    © 2021 Oscar Williams. All Rights Reserved
                </p>

                <div class="actions customFadeInUp">
                    <a href="{{ url('login') }}" class="btn-pill btn-pill-primary btn-pill-lg">Sign In</a>
                </div>
                <div class="">
                    <img style="margin-top: 24px; margin-bottom: 24px; width: 1000px; float:right;" src="{{ url('images/macbook-pro.png') }}">
                </div>
            </div>

        </div>



        <script type="text/javascript">
            $(function () {
                var trigger = new ScrollTrigger({
                    toggle: {
                        visible: 'customFadeInUp'
                    },
                    offset: {
                        y: 150
                    },
                    once: true
                });
            });
        </script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            // (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            // function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            // e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            // e.src='//www.google-analytics.com/analytics.js';
            // r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            // ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
