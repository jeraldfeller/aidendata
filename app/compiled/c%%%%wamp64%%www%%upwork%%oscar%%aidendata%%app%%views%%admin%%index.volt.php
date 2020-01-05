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

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
        <script src="<?= $this->url->get('js/bootstrap/bootstrap.min.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/jquery.dataTables.min.js') ?>"></script>
        <script src="<?= $this->url->get('js/vendor/jquery.cookie.js') ?>"></script>
        <script src="<?= $this->url->get('js/theme.js') ?>"></script>
        <script src="<?= $this->url->get('js/aiden.js') ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.6.1/jquery.timeago.min.js"></script>

        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <title><?= $pageTitle ?> — <?= $this->config->application->title ?></title>
        
        
    </head>
    <body id="latest-activity">
        

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
                        Home
                    </div>

                </div>

                <div class="content-wrapper">

                    <div class="text-center">
                        <?php if ($page['totalPages'] > 1) { ?>
    <nav class="text-xs-center">
        <ul class="pagination">

            <?php if ($_url['amountOfGetParams'] > 0) { ?>
                <?php $_paginationUrl = $_url['completeUrl']; ?>
            <?php } else { ?>
                <?php $_paginationUrl = $_url['baseUrl']; ?>
            <?php } ?>

            
            <?php if ($page['current'] > 6) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_paginationUrl ?>">First</a>
                </li>
            <?php } ?>

            
            <?php if ($page['current'] > 1) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . ($page['current'] - 1) ?>">Previous</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . ($page['current'] - 1) ?>">Previous</a>
                    <?php } ?>
                </li>
            <?php } ?>

            
            <?php if ($page['current'] - 5 > 1) { ?>
                <?php $threePagesBack = $page['current'] - 5; ?>
                <?php foreach (range($threePagesBack, $page['current'] - 1) as $i) { ?>
                    <li class="page-item">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php } ?>

                
                <li class="page-item active">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page['current'] ?>"><?= $page['current'] ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page['current'] ?>"><?= $page['current'] ?></a>
                    <?php } ?>
                </li>

                
            <?php } else { ?>
                <?php foreach (range(1, $page['current']) as $i) { ?>
                    <li class="page-item<?php if ($i == $page['current']) { ?> active<?php } ?>">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php foreach (range($page['current'] + 1, $page['current'] + 5) as $i) { ?>
                <?php if ($i > $page['totalPages']) { ?>
                    <?php break; ?>
                <?php } ?>

                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                    <?php } ?>
                </li>
            <?php } ?>


            
            <?php if ($page['next'] != $page['current'] && $page['next'] != 0) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page['next'] ?>">Next</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page['next'] ?>">Next</a>
                    <?php } ?>
                </li>

            <?php } ?>
        </ul>
    </nav>
<?php } ?>

                    </div>


                    <?php $v38044883971iterator = $pdfs; $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $pdf) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>

                        <div class="moment<?php if ($v38044883971loop->first) { ?> first<?php } ?>">
                            <div class="row event clearfix">
                                <div class="col-sm-1">
                                    <div class="icon">
                                        <i class="fa fa-comment"></i>
                                    </div>
                                </div>
                                <div class="col-sm-11 message">
                                    <?php if ($pdf->ScrapeSource->image != null) { ?>
                                        <img class="avatar" src="<?= $this->url->get('images/council/' . $pdf->ScrapeSource->image) ?>">
                                    <?php } ?>
                                    <div class="content">
                                        <strong><?= $pdf->ScrapeSource->name ?></strong> has uploaded 
                                        <a href="<?= $this->url->get('pdfs/view?id=' . $pdf->id) ?>"><?= $pdf->getFileName() ?></a> 
                                        containing<strong> <?= $pdf->matches->count() ?> phrases</strong> 
                                        <?php if ($pdf->last_checked != null) { ?>
                                            <time class="timeago text-muted small" datetime="<?= \DateTime::createFromFormat("Y-m-d H:i:s", $pdf->last_checked)->format('c') ?>">
                                                <?= $pdf->last_checked ?>
                                            </time>
                                        <?php } ?>

                                        <p class="border-bottom">
                                            <?php foreach ($pdf->matches as $match) { ?>
                                                <span class="btn btn-sm btn-default"><?= $match->Phrase->text ?> (Page <?= $match->page ?>)</span>
                                            <?php } ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php $v38044883971incr++; } ?>

                    <div class="text-center">
                        <?php if ($page['totalPages'] > 1) { ?>
    <nav class="text-xs-center">
        <ul class="pagination">

            <?php if ($_url['amountOfGetParams'] > 0) { ?>
                <?php $_paginationUrl = $_url['completeUrl']; ?>
            <?php } else { ?>
                <?php $_paginationUrl = $_url['baseUrl']; ?>
            <?php } ?>

            
            <?php if ($page['current'] > 6) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_paginationUrl ?>">First</a>
                </li>
            <?php } ?>

            
            <?php if ($page['current'] > 1) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . ($page['current'] - 1) ?>">Previous</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . ($page['current'] - 1) ?>">Previous</a>
                    <?php } ?>
                </li>
            <?php } ?>

            
            <?php if ($page['current'] - 5 > 1) { ?>
                <?php $threePagesBack = $page['current'] - 5; ?>
                <?php $v38044883971iterator = range($threePagesBack, $page['current'] - 1); $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $i) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>
                    <li class="page-item">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v38044883971incr++; } ?>

                
                <li class="page-item active">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page['current'] ?>"><?= $page['current'] ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page['current'] ?>"><?= $page['current'] ?></a>
                    <?php } ?>
                </li>

                
            <?php } else { ?>
                <?php $v38044883971iterator = range(1, $page['current']); $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $i) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>
                    <li class="page-item<?php if ($i == $page['current']) { ?> active<?php } ?>">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v38044883971incr++; } ?>
            <?php } ?>

            <?php $v38044883971iterator = range($page['current'] + 1, $page['current'] + 5); $v38044883971incr = 0; $v38044883971loop = new stdClass(); $v38044883971loop->self = &$v38044883971loop; $v38044883971loop->length = count($v38044883971iterator); $v38044883971loop->index = 1; $v38044883971loop->index0 = 1; $v38044883971loop->revindex = $v38044883971loop->length; $v38044883971loop->revindex0 = $v38044883971loop->length - 1; ?><?php foreach ($v38044883971iterator as $i) { ?><?php $v38044883971loop->first = ($v38044883971incr == 0); $v38044883971loop->index = $v38044883971incr + 1; $v38044883971loop->index0 = $v38044883971incr; $v38044883971loop->revindex = $v38044883971loop->length - $v38044883971incr; $v38044883971loop->revindex0 = $v38044883971loop->length - ($v38044883971incr + 1); $v38044883971loop->last = ($v38044883971incr == ($v38044883971loop->length - 1)); ?>
                <?php if ($i > $page['totalPages']) { ?>
                    <?php break; ?>
                <?php } ?>

                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                    <?php } ?>
                </li>
            <?php $v38044883971incr++; } ?>


            
            <?php if ($page['next'] != $page['current'] && $page['next'] != 0) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page['next'] ?>">Next</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page['next'] ?>">Next</a>
                    <?php } ?>
                </li>

            <?php } ?>
        </ul>
    </nav>
<?php } ?>

                    </div>

                </div>

            </div>

        </div>
    </div>




    </body>
</html>