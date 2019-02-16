<?php

namespace Aiden\Forms;

class CreateScrapeSourceForm extends \Phalcon\Forms\Form {

    public function initialize() {

        // Source name
        $sourceName = new \Phalcon\Forms\Element\Text('source_name', [
            'class' => 'form-control',
            'placeholder' => 'e.g. Willow Capital',
            'autofocus' => '',
            'required' => '',
        ]);
        $sourceName
                ->setLabel('Source name:')
                ->addValidators([
                    new \Phalcon\Validation\Validator\StringLength([
                        'max' => 254,
                        'min' => 1,
                        'messageMaximum' => 'The specified name is too long.',
                        'messageMinimum' => 'The specified name is too short.',
                        'cancelOnFail' => true,
                            ]),
        ]);
        $this->add($sourceName);

        // Submit
        $submit = new \Phalcon\Forms\Element\Submit('submit', [
            'value' => 'Submit',
            'class' => 'btn btn-success'
        ]);
        $this->add($submit);

    }

}
