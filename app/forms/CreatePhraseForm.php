<?php

namespace Aiden\Forms;

class CreatePhraseForm extends \Phalcon\Forms\Form {

    public function initialize() {

        $phraseName = new \Phalcon\Forms\Element\Text('phrase', [
            'class' => 'form-control',
            'placeholder' => 'Phrase',
            'autofocus' => '',
            'required' => '',
        ]);
        $phraseName
                ->setLabel('Phrase:')
                ->addValidators([
                    new \Phalcon\Validation\Validator\StringLength([
                        'max' => 255,
                        'min' => 1,
                        'messageMaximum' => 'The specified phrase is too long.',
                        'messageMinimum' => 'The specified phrase is too short.',
                        'cancelOnFail' => true,
                            ]),
        ]);
        $this->add($phraseName);

        $caseSensitive = new \Phalcon\Forms\Element\Check('case_sensitive', [
            'value' => 1,
            'class' => 'form-check-input'
        ]);
        $caseSensitive->setLabel('Case sensitive');
        $this->add($caseSensitive);

        // Submit
        $submit = new \Phalcon\Forms\Element\Submit('submit', [
            'value' => 'Submit',
            'class' => 'btn btn-success'
        ]);
        $this->add($submit);

    }

}
