<!DOCTYPE html>
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
        
        
    </head>
    <body id="dashboard">
        
    <div id="wrapper">
        <div id="sidebar-default" class="main-sidebar">
    <div class="current-user">
        <a href="index.html" class="name">
            <img class="avatar" src="images/avatars/aiden.jpg">
            <span>
                <?= $this->session->get('auth')['user']->name ?>
                <i class="fa fa-chevron-down"></i>
            </span>
        </a>
        <ul class="menu">
            <li>
                <a href="<?= $this->url->get('login/destroy') ?>">Logout</a>
            </li>
        </ul>
    </div>
    <div class="menu-section">

        <h3>General</h3>
        <ul>
            <li>
                <a href="<?= $this->url->get('dashboard') ?>" <?php if ($this->router->getControllerName() == 'dashboard') { ?> class="active"<?php } ?>>
                    <i class="ion-stats-bars"></i> 
                    <span>Dashboard</span>
                </a>
                <a href="<?= $this->url->get('admin') ?>" <?php if ($this->router->getControllerName() == 'admin') { ?> class="active"<?php } ?>>
                    <i class="ion-android-earth"></i> 
                    <span>Newsfeed</span>
                </a>
                <li>
                    <a href="<?= $this->url->get('pdfs') ?>" <?php if ($this->router->getControllerName() == 'pdfs') { ?> class="active"<?php } ?>>
                        <i class="ion-pricetags"></i> 
                        <span>Documents</span>
                    </a>
                </li>
            </li>

        </ul>

    </div>

    <div class="menu-section">

        <h3>Settings</h3>
        <ul>

            <li>
                <a href="<?= $this->url->get('phrases') ?>" <?php if ($this->router->getControllerName() == 'phrases') { ?> class="active"<?php } ?>>
                    <i class="ion-pricetags"></i> 
                    <span>Phrases</span>
                </a>
            </li>

            <li>
                <a href="<?= $this->url->get('sources') ?>" <?php if ($this->router->getControllerName() == 'sources') { ?> class="active"<?php } ?>>
                    <i class="ion-pricetags"></i> 
                    <span>Sources</span>
                </a>
            </li>

            <li>
                <a href="<?= $this->url->get('management') ?>" <?php if ($this->router->getControllerName() == 'management') { ?> class="active"<?php } ?>>
                    <i class="ion-usb"></i> 
                    <span>Management</span>
                </a>

            </li>

        </ul>

    </div>
    
</div>

        <div id="content">

            <div class="panel">

                <div class="menubar">
                    <div class="sidebar-toggler visible-xs">
                        <i class="ion-navicon"></i>
                    </div>

                    <div class="page-title">
                        Dashboard
                    </div>


                    <div class="period-select hidden-xs">
                        <form class="input-daterange">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar-o"></i>
                                </span>
                                <input name="start" type="text" class="form-control datepicker" value="<?= $firstDoM ?>" placeholder="<?= $firstDoM ?>" />
                            </div>

                            <p class="pull-left">to</p>

                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar-o"></i>
                                </span>
                                <input name="end" type="text" class="form-control datepicker" value="<?= $today ?>" placeholder="<?= $today ?>" />
                            </div>
                        </form>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="metrics clearfix">
                        <div class="metric">
                            <span class="field">Documents</span>
                            <span class="data"><?= $statistics['periodPdfs_count'] ?></span>
                        </div>
                        <div class="metric">
                            <span class="field">Phrases</span>
                            <span class="data"><?= $statistics['periodPhrasesFound_count'] ?></span>
                        </div>
                        <div class="metric">
                            <span class="field">Total Documents</span>
                            <span class="data"><?= $statistics['totalPdfs_count'] ?></span>
                        </div>
                        <div class="metric">
                            <span class="field">Councils</span>
                            <span class="data"><?= $statistics['totalCouncils_count'] ?></span>
                        </div>
                    </div>

                    <div class="chart">
                        <h3>
                            Documents Crawled

                            <div class="total pull-right hidden-xs">
                                <?= $statistics['periodPdfs_count'] ?> total

                                <div class="change up">
                                    <i class="fa fa-chevron-up"></i>
                                    10%
                                </div>
                            </div>
                        </h3>
                        <div id="pdf-crawl-chart"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="chart">
                                <h3>
                                    Recent Activity

                                    <div class="total pull-right hidden-xs">
                                        <a href="">View Feed</a>
                                    </div>
                                </h3>
                                <div class="users-list">
                                    <div class="row headers">
                                        <div class="col-sm-4 header hidden-xs">
                                            <label>Council</label>
                                        </div>
                                        <div class="col-sm-5 header hidden-xs">
                                            <label>Pdf</label>
                                        </div>
                                        <div class="col-sm-3 header hidden-xs">
                                            <label>Phrases</label>
                                        </div>
                                    </div>
                                    <?php foreach ($pdfs as $pdf) { ?>
                                        <div class="row user">
                                            <div class="col-sm-4">
                                                <strong><?= $pdf->ScrapeSource->name ?></strong>
                                            </div>
                                            <div class="col-sm-5">
                                                <a href="<?= $this->url->get('pdfs/view?id=' . $pdf->id) ?>"><?= $pdf->getFileName() ?></a>
                                            </div>
                                            <div class="col-sm-3">
                                                <?= $pdf->matches->count() ?> phrases
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="chart">
                                <h3>
                                    Top Sources

                                    <div class="total pull-right hidden-xs">
                                        <?= $statistics['periodPdfs_count'] ?> total

                                        <div class="change down">
                                            <i class="fa fa-chevron-down"></i>
                                            3.5%
                                        </div>
                                    </div>
                                </h3>
                                <div class="referrals">
                                    <?php foreach ($statistics['periodScrapeSources'] as $source) { ?>
                                        <div class="referral">
                                            <span>
                                                <?= $source->name ?>

                                                <div class="pull-right">
                                                    <span class="data"><?= $source->count ?></span>  <?= round($source->count / $statistics['periodPdfs_count'] * 100, 2) ?>%
                                                </div>
                                            </span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?= round($source->count / $statistics['periodPdfs_count'] * 100, 2) ?>%">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


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
            
    var chart_data = [<?php $v34315936761iterator = $statistics['periodPdfs']; $v34315936761incr = 0; $v34315936761loop = new stdClass(); $v34315936761loop->self = &$v34315936761loop; $v34315936761loop->length = count($v34315936761iterator); $v34315936761loop->index = 1; $v34315936761loop->index0 = 1; $v34315936761loop->revindex = $v34315936761loop->length; $v34315936761loop->revindex0 = $v34315936761loop->length - 1; ?><?php foreach ($v34315936761iterator as $pdf) { ?><?php $v34315936761loop->first = ($v34315936761incr == 0); $v34315936761loop->index = $v34315936761incr + 1; $v34315936761loop->index0 = $v34315936761incr; $v34315936761loop->revindex = $v34315936761loop->length - $v34315936761incr; $v34315936761loop->revindex0 = $v34315936761loop->length - ($v34315936761incr + 1); $v34315936761loop->last = ($v34315936761incr == ($v34315936761loop->length - 1)); ?>
    <?php if (!$v34315936761loop->last) { ?>
        ["<?= date('Y-m-d', strtotime($pdf->last_checked)) ?>", 1],
    <?php } ?>
    <?php if ($v34315936761loop->last) { ?>
        ["<?= date('Y-m-d', strtotime($pdf->last_checked)) ?>", 1]
    <?php } ?>
    <?php $v34315936761incr++; } ?>
        ];

        d = chart_data.reduce(function(acc_data, row) {
        if (!acc_data.hasOwnProperty(row[0])) {
        acc_data[row[0]] = 0;
        }
        acc_data[row[0]]++;
        return acc_data;
        }, {})

        d = Object.keys(d).map(function(da) {
        return [utils.get_timestamp_by_date(da), d[da]];
        });

        

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