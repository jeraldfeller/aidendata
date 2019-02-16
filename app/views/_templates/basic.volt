<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="{{ url('css/compiled/theme.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/ionicons.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/brankic.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/font-awesome.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/jquery.dataTables.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/animate.css') }}">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="{{ url('js/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ url('js/vendor/jquery.dataTables.min.js') }}"></script>
        <script src="{{ url('js/vendor/jquery.cookie.js') }}"></script>
        <script src="{{ url('js/theme.js') }}"></script>
        <script src="{{ url('js/aiden.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.1/jquery.timeago.min.js"></script>

        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <title>{{ pageTitle }} — {{ config.application.title }}</title>
        {% block extra_head %}
        {%endblock %}
    </head>
    <body{% block body_attributes %}{% endblock %}>
        {% block body %}
        {% endblock %}


    </body>
</html>