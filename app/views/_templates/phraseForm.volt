<div class="panel panel-default">
    <div class="panel-heading">Create Phrase</div>
    <div class="panel-body">

        {{ form('phrases/create', 'method' : 'post', 'class' : 'form-horizontal') }}

        <div class="form-group">
            <label class="col-sm-3 col-md-3 control-label">{{ phraseForm.label('phrase') }}</label>
            <div class="col-sm-9 col-md-9">
                {{ phraseForm.render('phrase') }}
            </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9">
            <div class="form-group">
                <div class="checkbox">
                    {{ phraseForm.render('case_sensitive') }} {{ phraseForm.label('case_sensitive') }}
                </div>
            </div>
        </div>

        <div class="text-center">
            {{ phraseForm.render('submit') }}
        </div>

        {{ end_form() }}

    </div>
</div>
