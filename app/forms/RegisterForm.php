<?php

namespace Aiden\Forms;

class RegisterForm extends \Phalcon\Forms\Form {

    public function initialize() {

        // Email
        $email = new \Phalcon\Forms\Element\Email('email', [
            'class' => 'form-control',
            'placeholder' => 'Enter an email address',
            'autofocus' => '',
            'required' => '',
        ]);
        $email
                ->setLabel('Email:')
                ->addValidators([
                    new \Phalcon\Validation\Validator\StringLength([
                        'max' => 254,
                        'min' => 1,
                        'messageMaximum' => 'The specified email is too long.',
                        'messageMinimum' => 'The specified email is too short.',
                        'cancelOnFail' => true,
                            ]),
                    new \Phalcon\Validation\Validator\Email([
                        'message' => 'Please use a valid email address.',
                        'cancelOnFail' => true,
                            ]),
                    new \Phalcon\Validation\Validator\Uniqueness([
                        'model' => new \Aiden\Models\Users(),
                        'with' => 'email',
                        'message' => 'The email address is already being used',
                        'cancelOnFail' => true,
                            ]),
        ]);
        $this->add($email);

        // Password
        $password = new \Phalcon\Forms\Element\Password('password', [
            'class' => 'form-control',
            'placeholder' => 'Enter a password',
            'required' => '',
        ]);
        $password
                ->setLabel('Password:')
                ->addValidator(
                        new \Phalcon\Validation\Validator\PresenceOf([
                    'message' => 'Please enter a password.',
                    'cancelOnFail' => true,
                        ])
        );
        $this->add($password);

        // Password confirmation
        $passwordConfirmation = new \Phalcon\Forms\Element\Password('password_confirmation', [
            'class' => 'form-control',
            'placeholder' => 'Enter a password confirmation',
            'required' => '',
        ]);
        $passwordConfirmation
                ->setLabel('Password Confirmation:')
                ->addValidators([
                    new \Phalcon\Validation\Validator\PresenceOf([
                        'message' => 'Please enter a password confirmation.',
                        'cancelOnFail' => true,
                            ]),
                    new \Phalcon\Validation\Validator\Confirmation([
                        'message' => 'The passwords do not match',
                        'with' => 'password'
                            ]),
        ]);
        $this->add($passwordConfirmation);

        // Submit
        $submit = new \Phalcon\Forms\Element\Submit('submit', [
            'value' => 'Submit',
            'class' => 'btn btn-success'
        ]);
        $this->add($submit);

    }

}
