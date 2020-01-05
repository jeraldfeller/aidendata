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


