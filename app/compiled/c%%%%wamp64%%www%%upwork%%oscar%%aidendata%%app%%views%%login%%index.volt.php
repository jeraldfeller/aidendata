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
    <body id="signin">
        

    <h3>&nbsp;</h3>

    <div class="content">
        
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




        <div class="header">
            <h4>Login</h4>
        </div>
            
        <?= $this->tag->form(['login/do', 'method' => 'post']) ?>

        <div class="fields">
            <?= $form->label('email') ?>
            <?= $form->render('email') ?>
        </div>

        <div class="fields">
            <?= $form->label('password') ?>
            <?= $form->render('password') ?>
        </div>

        <div class="actions">
            <?= $form->render('submit') ?>
        </div>

        <?= $this->tag->endform() ?>
    </div>

    <div class="bottom-wrapper">
        <div class="message">
            <a href="<?= $this->url->get('register') ?>">Sign up</a>
        </div>
    </div>




    </body>
</html>