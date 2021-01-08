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
    <body id="datatables">
        

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

            <div class="menubar">
                <div class="sidebar-toggler visible-xs">
                    <i class="ion-navicon"></i>
                </div>

                <div class="page-title">
                    Phrases
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




                <?php if ($this->length($phrases) > 0) { ?>

                    <div id="phrases-datatable" class="dataTables_wrapper my-3" role="grid">

                        <table id="phrase-table" class="dataTable">
                            <thead>
                                <tr>
                                    <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Phrase</th>
                                    <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Case Sensitive</th>
                                    <th scope="columnheader" class="sorting" aria-controls="phrases-datatable">Occurences</th>
                                    <th scope="columnheader">Options</th>
                                </tr>
                            </thead>
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <?php $v15673597701iterator = $phrases; $v15673597701incr = 0; $v15673597701loop = new stdClass(); $v15673597701loop->self = &$v15673597701loop; $v15673597701loop->length = count($v15673597701iterator); $v15673597701loop->index = 1; $v15673597701loop->index0 = 1; $v15673597701loop->revindex = $v15673597701loop->length; $v15673597701loop->revindex0 = $v15673597701loop->length - 1; ?><?php foreach ($v15673597701iterator as $phrase) { ?><?php $v15673597701loop->first = ($v15673597701incr == 0); $v15673597701loop->index = $v15673597701incr + 1; $v15673597701loop->index0 = $v15673597701incr; $v15673597701loop->revindex = $v15673597701loop->length - $v15673597701incr; $v15673597701loop->revindex0 = $v15673597701loop->length - ($v15673597701incr + 1); $v15673597701loop->last = ($v15673597701incr == ($v15673597701loop->length - 1)); ?>
                                    <tr class="<?php if ($v15673597701loop->index % 2) { ?>odd<?php } else { ?>even<?php } ?>">
                                        <td><?= $this->escaper->escapeHtml($phrase->text) ?></td>
                                        <td>
                                            <?php echo ($phrase->case_sensitive ? 'Yes' : 'No'); ?>
                                        </td>
                                        <td><?= $this->length($phrase->Matches) ?></td>
                                        <td>
                                            <div class="dropdown">
    <button 
        class="btn btn-default dropdown-toggle"
        type="button" 
        id="dropdownMenu-<?= $phrase->id ?>" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        Options <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="<?= $this->url->get('phrases/toggleCase?id=' . $phrase->id) ?>">Flip Case Sensitivity</a>
        </li>
        <li>
            <a href="<?= $this->url->get('phrases/delete?id=' . $phrase->id) ?>">Delete</a>
        </li>
    </ul>
</div>

                                        </td>
                                    </tr>
                                <?php $v15673597701incr++; } ?>
                            </tbody>
                        </table>

                    </div>

                <?php } else { ?>

                    <div class="text-center">
                        There are no phrases available.
                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#phrase-table').DataTable({
                "bPaginate": false,
            });
        });
    </script>



    </body>
</html>