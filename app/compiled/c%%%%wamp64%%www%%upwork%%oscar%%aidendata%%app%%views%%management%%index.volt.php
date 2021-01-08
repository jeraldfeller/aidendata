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
    <body>
        

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
                        Management
                    </div>
                </div>

                <div class="content-wrapper">

                    <?php if ($this->flashSession->has('error')) { ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <?= $this->flashSession->output(true) ?>
    </div>
<?php } ?>
<?php if ($this->flashSession->has('success')) { ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <?= $this->flashSession->output(true) ?>
    </div>
<?php } ?>
<?php if ($this->flashSession->has('notice')) { ?>
    <div class="alert alert-info alert-dismissible" role="alert">
        <?= $this->flashSession->output(true) ?>
    </div>
<?php } ?>




                    <div class="row">

                        <div class="col-lg-6">
                            <div class="panel panel-default">
    <div class="panel-heading">Create Scrape Source</div>
    <div class="panel-body">
        <?= $this->tag->form(['sources/create', 'method' => 'post', 'class' => 'form-horizontal']) ?>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $scrapeSourceForm->label('source_name') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $scrapeSourceForm->render('source_name') ?>
            </div>
        </div>

        <div class="text-center">
            <?= $scrapeSourceForm->render('submit') ?>
        </div>
        <?= $this->tag->endForm() ?>
    </div>
</div>


                            <div class="panel panel-default">
    <div class="panel-heading">Create Phrase</div>
    <div class="panel-body">

        <?= $this->tag->form(['phrases/create', 'method' => 'post', 'class' => 'form-horizontal']) ?>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $phraseForm->label('phrase') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $phraseForm->render('phrase') ?>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <div class="form-group">
                <div class="checkbox">
                    <?= $phraseForm->render('case_sensitive') ?> <?= $phraseForm->label('case_sensitive') ?>
                </div>
            </div>
        </div>

        <div class="text-center">
            <?= $phraseForm->render('submit') ?>
        </div>

        <?= $this->tag->endForm() ?>

    </div>
</div>

                        </div>

                        <div class="col-lg-6">

                            <div class="panel panel-default">
    <div class="panel-heading">Create Scrape Source</div>
    <div class="panel-body">
        <?= $this->tag->form(['urls/create', 'method' => 'post', 'class' => 'form-horizontal']) ?>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $scrapeUrlForm->label('source_id') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $scrapeUrlForm->render('source_id') ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $scrapeUrlForm->label('source_scrape_url') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $scrapeUrlForm->render('source_scrape_url') ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $scrapeUrlForm->label('source_regex_pattern') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $scrapeUrlForm->render('source_regex_pattern') ?>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <div class="form-group">
                <div class="checkbox">
                    <?= $scrapeUrlForm->render('source_check_adjacent') ?> <?= $scrapeUrlForm->label('source_check_adjacent') ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $scrapeUrlForm->label('source_depth_level') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $scrapeUrlForm->render('source_depth_level') ?>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <div class="form-group">
                <div class="checkbox">
                    <?= $scrapeUrlForm->render('source_check_domain') ?> <?= $scrapeUrlForm->label('source_check_domain') ?>
                </div>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <div class="form-group">
                <div class="checkbox">
                    <?= $scrapeUrlForm->render('source_is_post') ?> <?= $scrapeUrlForm->label('source_is_post') ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label"><?= $scrapeUrlForm->label('source_post_params') ?></label>
            <div class="col-sm-9 col-md-9">
                <?= $scrapeUrlForm->render('source_post_params') ?>
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <div class="form-group">
                <div class="checkbox">
                    <?= $scrapeUrlForm->render('source_url_encoded') ?> <?= $scrapeUrlForm->label('source_url_encoded') ?>
                </div>
            </div>
        </div>

        <div class="text-center">
            <?= $scrapeSourceForm->render('submit') ?>
        </div>
        <?= $this->tag->endForm() ?>
    </div>
</div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>




    </body>
</html>