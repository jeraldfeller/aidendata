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

