<?php

namespace Luma\SecurityComponent\Form;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\PasswordInputField;
use Luma\FormComponent\Form\Field\TextInputField;

class LoginForm extends AbstractForm
{
    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    protected function build(): void
    {
        $this->addFormField(new TextInputField([
            'name' => 'emailAddress',
            'label' => 'Email Address',
            'id' => 'email-address-input',
            'required' => true,
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'password',
            'label' => 'Password',
            'id' => 'password-input',
            'required' => true,
        ]));
    }
}