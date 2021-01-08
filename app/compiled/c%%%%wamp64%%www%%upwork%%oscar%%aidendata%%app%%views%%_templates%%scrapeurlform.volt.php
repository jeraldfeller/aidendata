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