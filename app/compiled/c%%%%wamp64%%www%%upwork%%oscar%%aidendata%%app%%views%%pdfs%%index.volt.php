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
                        PDFs
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



                    <?php if ($this->length($page->items) > 0) { ?>

                        <div class="text-center">
                            <?php if ($page->total_pages > 1) { ?>
    <nav class="text-xs-center">
        <ul class="pagination">

            <?php if ($_url['amountOfGetParams'] > 0) { ?>
                <?php $_paginationUrl = $_url['completeUrl']; ?>
            <?php } else { ?>
                <?php $_paginationUrl = $_url['baseUrl']; ?>
            <?php } ?>

            
            <?php if ($page->current > 6) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_paginationUrl ?>">First</a>
                </li>
            <?php } ?>

            
            <?php if ($page->current > 1) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . ($page->current - 1) ?>">Previous</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . ($page->current - 1) ?>">Previous</a>
                    <?php } ?>
                </li>
            <?php } ?>

            
            <?php if ($page->current - 5 > 1) { ?> 
                <?php $threePagesBack = $page->current - 5; ?>
                <?php foreach (range($threePagesBack, $page->current - 1) as $i) { ?>
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
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page->current ?>"><?= $page->current ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page->current ?>"><?= $page->current ?></a>
                    <?php } ?>
                </li>

                
            <?php } else { ?> 
                <?php foreach (range(1, $page->current) as $i) { ?>
                    <li class="page-item<?php if ($i == $page->current) { ?> active<?php } ?>">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php foreach (range($page->current + 1, $page->current + 5) as $i) { ?>
                <?php if ($i > $page->total_pages) { ?>
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


            
            <?php if ($page->next != $page->current && $page->next != 0) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page->next ?>">Next</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page->next ?>">Next</a>
                    <?php } ?>
                </li>

            <?php } ?>
        </ul>
    </nav>
<?php } ?>

                        </div>  

                        <div id="pdf-datatable" class="dataTables_wrapper" role="grid">

                            <table id="pdf-table" class="dataTable">
                                <thead>
                                    <tr role="row">
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Sources</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">URL</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Status</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Phrases Found</th>
                                        <th scope="columnheader" class="sorting" aria-controls="pdf-datatable">Last checked</th>
                                        <th scope="columnheader">Options</th>
                                    </tr>
                                </thead>
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <?php $v15276023211iterator = $page->items; $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $pdf) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                                        <tr class="<?php if ($v15276023211loop->index % 2) { ?>odd<?php } else { ?>even<?php } ?>">
                                            <td><?= $this->escaper->escapeHtml($pdf->ScrapeSource->name) ?></td>
                                           
                                            <td>
                                                <a href="<?= $this->url->get('pdfs/view?id=' . $pdf->id) ?>">
                                                    <?= $pdf->getFileName() ?>
                                                </a>
                                            </td>
                                            <td class="text-center"><?= $pdf->getStatusString() ?></td>
                                            <td class="text-center"><?= $this->length($pdf->Matches) ?></td>

                                            <td>
                                                <?php if ($pdf->last_checked != null) { ?>
                                                    <time class="timeago text-muted small" datetime="<?= \DateTime::createFromFormat("Y-m-d H:i:s", $pdf->last_checked)->format('c') ?>">
                                                        <?= $pdf->last_checked ?>
                                                    </time>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <div class="dropdown">
    <button 
        class="btn btn-default dropdown-toggle"
        type="button" 
        id="dropdownMenu-<?= $pdf->id ?>" 
        data-toggle="dropdown" 
        aria-haspopup="true" 
        aria-expanded="false">
        Options <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <li>
            <a href="<?= $pdf->url ?>">View PDF</a>
        </li>
        <li>
            <a href="<?= $this->url->get('pdfs/delete?id=' . $pdf->id) ?>">Delete</a>
        </li>
    </ul>
</div>

                                            </td>
                                        </tr>
                                    <?php $v15276023211incr++; } ?>
                                </tbody>
                            </table>

                        </div>

                        <div class="text-center">
                            <?php if ($page->total_pages > 1) { ?>
    <nav class="text-xs-center">
        <ul class="pagination">

            <?php if ($_url['amountOfGetParams'] > 0) { ?>
                <?php $_paginationUrl = $_url['completeUrl']; ?>
            <?php } else { ?>
                <?php $_paginationUrl = $_url['baseUrl']; ?>
            <?php } ?>

            
            <?php if ($page->current > 6) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $_paginationUrl ?>">First</a>
                </li>
            <?php } ?>

            
            <?php if ($page->current > 1) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . ($page->current - 1) ?>">Previous</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . ($page->current - 1) ?>">Previous</a>
                    <?php } ?>
                </li>
            <?php } ?>

            
            <?php if ($page->current - 5 > 1) { ?> 
                <?php $threePagesBack = $page->current - 5; ?>
                <?php $v15276023211iterator = range($threePagesBack, $page->current - 1); $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $i) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                    <li class="page-item">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v15276023211incr++; } ?>

                
                <li class="page-item active">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page->current ?>"><?= $page->current ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page->current ?>"><?= $page->current ?></a>
                    <?php } ?>
                </li>

                
            <?php } else { ?> 
                <?php $v15276023211iterator = range(1, $page->current); $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $i) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                    <li class="page-item<?php if ($i == $page->current) { ?> active<?php } ?>">
                        <?php if ($_url['amountOfGetParams'] > 0) { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                        <?php } else { ?>
                            <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                        <?php } ?>
                    </li>
                <?php $v15276023211incr++; } ?>
            <?php } ?>

            <?php $v15276023211iterator = range($page->current + 1, $page->current + 5); $v15276023211incr = 0; $v15276023211loop = new stdClass(); $v15276023211loop->self = &$v15276023211loop; $v15276023211loop->length = count($v15276023211iterator); $v15276023211loop->index = 1; $v15276023211loop->index0 = 1; $v15276023211loop->revindex = $v15276023211loop->length; $v15276023211loop->revindex0 = $v15276023211loop->length - 1; ?><?php foreach ($v15276023211iterator as $i) { ?><?php $v15276023211loop->first = ($v15276023211incr == 0); $v15276023211loop->index = $v15276023211incr + 1; $v15276023211loop->index0 = $v15276023211incr; $v15276023211loop->revindex = $v15276023211loop->length - $v15276023211incr; $v15276023211loop->revindex0 = $v15276023211loop->length - ($v15276023211incr + 1); $v15276023211loop->last = ($v15276023211incr == ($v15276023211loop->length - 1)); ?>
                <?php if ($i > $page->total_pages) { ?>
                    <?php break; ?>
                <?php } ?>

                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $i ?>"><?= $i ?></a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $i ?>"><?= $i ?></a>
                    <?php } ?>
                </li>
            <?php $v15276023211incr++; } ?>


            
            <?php if ($page->next != $page->current && $page->next != 0) { ?>
                <li class="page-item">
                    <?php if ($_url['amountOfGetParams'] > 0) { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '&page=' . $page->next ?>">Next</a>
                    <?php } else { ?>
                        <a class="page-link" href="<?= $_paginationUrl . '?page=' . $page->next ?>">Next</a>
                    <?php } ?>
                </li>

            <?php } ?>
        </ul>
    </nav>
<?php } ?>

                        </div>  

                    <?php } else { ?>

                        <div class="text-center">
                            There are no PDFs available.
                        </div>

                    <?php } ?>
                </div>

        </div>

    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#pdf-table').DataTable({
                "bPaginate": false,
            });
        });
    </script>



    </body>
</html>