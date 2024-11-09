<?php

namespace Luma\SecurityComponent\Form;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\PasswordInputField;
use Luma\FormComponent\Form\Field\SubmitButton;
use Luma\FormComponent\Form\Field\TextInputField;
use Luma\Framework\Luma;

class RegistrationForm extends AbstractForm
{
    private string $userClass;

    public function __construct()
    {
        $this->userClass = Luma::getConfigParam('security.userClass');
        parent::__construct();
    }

    /**
     * @return void
     *
     * @throws InvalidFieldOptionException|MissingFieldOptionException
     */
    protected function build(): void
    {
        $this->addFormField(new TextInputField([
            'name' => 'username',
            'id' => 'username',
            'label' => 'Username',
            'required' => true,
            'placeholder' => 'Username',
        ]));
        $this->addFormField(new EmailInputField([
            'name' => 'emailAddress',
            'id' => 'email-address',
            'label' => 'Email Address',
            'required' => true,
            'placeholder' => 'Email Address',
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'password',
            'id' => 'password',
            'label' => 'Password',
            'required' => true,
            'placeholder' => 'Password',
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'repeatPassword',
            'id' => 'repeat-password',
            'label' => 'Repeat Password',
            'required' => true,
            'placeholder' => 'Repeat Password',
        ]));
        $this->addFormField(new SubmitButton([
            'name' => 'Register',
            'id' => 'register',
        ]));
    }
}