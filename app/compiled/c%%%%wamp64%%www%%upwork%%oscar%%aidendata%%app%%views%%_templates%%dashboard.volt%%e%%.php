a:9:{i:0;s:2446:"<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/compiled/theme.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/vendor/ionicons.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/vendor/brankic.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/vendor/font-awesome.min.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/vendor/jquery.dataTables.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/vendor/animate.css') ?>">
        <link rel="stylesheet" type="text/css" href="<?= $this->url->get('css/vendor/datepicker.css') ?>" />

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="<?= $this->url->get('js/bootstrap/bootstrap.min.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/jquery.cookie.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/moment.min.js') ?>"></script>
        <script src="<?= $this->url->get('js/theme.js') ?>"></script>
        <script src="<?= $this->url->get('js/aiden.js') ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.1/jquery.timeago.min.js"></script>
        <script src="<?= $this->url->get('js/vendor/bootstrap-datepicker.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/raphael-min.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/morris.min.js') ?>"></script>

        <script src="<?= $this->url->get('js/vendor/jquery.flot/jquery.flot.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/jquery.flot/jquery.flot.time.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/jquery.flot/jquery.flot.tooltip.js') ?>"></script>

        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <title><?= $pageTitle ?> — <?= $this->config->application->title ?></title>
        ";s:10:"extra_head";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:10:"
        ";s:4:"file";s:90:"C:\wamp64\www\upwork\oscar\aidendata\app\config/../../app/views/\_templates/dashboard.volt";s:4:"line";i:36;}}i:1;s:24:"
    </head>
    <body";s:15:"body_attributes";N;i:2;s:11:">
        ";s:4:"body";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:10:"
        ";s:4:"file";s:90:"C:\wamp64\www\upwork\oscar\aidendata\app\config/../../app/views/\_templates/dashboard.volt";s:4:"line";i:40;}}i:3;s:1151:"

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
            ";s:10:"chart_data";a:1:{i:0;a:4:{s:4:"type";i:357;s:5:"value";s:14:"
            ";s:4:"file";s:90:"C:\wamp64\www\upwork\oscar\aidendata\app\config/../../app/views/\_templates/dashboard.volt";s:4:"line";i:74;}}i:4;s:2067:"

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
</html>";}