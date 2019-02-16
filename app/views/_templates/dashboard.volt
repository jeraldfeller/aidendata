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
        <link rel="stylesheet" type="text/css" href="{{ url('css/vendor/datepicker.css') }}" />

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="{{ url('js/bootstrap/bootstrap.min.js') }}"></script>
        <script src="{{ url('js/vendor/jquery.dataTables.min.js') }}"></script>
        <script src="{{ url('js/vendor/jquery.cookie.js') }}"></script>
        <script src="{{ url('js/vendor/moment.min.js') }}"></script>
        <script src="{{ url('js/theme.js') }}"></script>
        <script src="{{ url('js/aiden.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.1/jquery.timeago.min.js"></script>
        <script src="{{ url('js/vendor/bootstrap-datepicker.js') }}"></script>
        <script src="{{ url('js/vendor/raphael-min.js') }}"></script>
        <script src="{{ url('js/vendor/morris.min.js') }}"></script>

        <script src="{{ url('js/vendor/jquery.flot/jquery.flot.js') }}"></script>
        <script src="{{ url('js/vendor/jquery.flot/jquery.flot.time.js') }}"></script>
        <script src="{{ url('js/vendor/jquery.flot/jquery.flot.tooltip.js') }}"></script>

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

        <script type="text/javascript">
        $(function () {
            
            // Range Datepicker
            $('.input-daterange').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                orientation: 'right top',
            });
            function updateQueryStringParameter(uri, key, value) {
                var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                var separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                }
                else {
                    return uri + separator + key + "=" + value;
                }
            }

            $('.input-daterange').on('change', function(e) {
                var url = window.location.href;
                url = updateQueryStringParameter(url, 'from', e.target.value);
                window.location = url;
            });


            var chart_border_color = "#efefef";
            var chart_color = "#b0b3e3";

            var d = [];
            {% block chart_data %}
            {% endblock %}

            var d2 = [[utils.get_timestamp(14), 1500], [utils.get_timestamp(13), 1600], [utils.get_timestamp(12), 1630], [utils.get_timestamp(11), 1310], [utils.get_timestamp(10), 1530], [utils.get_timestamp(9), 2050], [utils.get_timestamp(8), 2310], [utils.get_timestamp(7), 2050], [utils.get_timestamp(6), 2125], [utils.get_timestamp(5), 1400], [utils.get_timestamp(4), 1600], [utils.get_timestamp(3), 1930], [utils.get_timestamp(2), 2000], [utils.get_timestamp(1), 2320]];
        
            var options = {
                xaxis : {
                    mode : "time",
                    tickLength : 10
                },
                series : {
                    lines : {
                        show : true,
                        lineWidth : 2,
                        fill : true,
                        fillColor : {
                            colors : [{
                                opacity : 0.04
                            }, {
                                opacity : 0.1
                            }]
                        }
                    },
                    shadowSize : 0
                },
                selection : {
                    mode : "x"
                },
                grid : {
                    hoverable : true,
                    clickable : true,
                    tickColor : chart_border_color,
                    borderWidth : 0,
                    borderColor : chart_border_color,
                },
                tooltip : true,
                colors : [chart_color]
            };
        
            var plot = $.plot($("#pdf-crawl-chart"), [d], $.extend(options, {
                tooltipOpts : {
                    content : "Visitors on <b>%x</b>: <span class='value'>%y</span>",
                    defaultTheme : false,
                    shifts: {
                        x: -75,
                        y: -70
                    }
                }
            }));
        });
        </script>

    </body>
</html>