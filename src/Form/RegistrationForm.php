<?php

namespace Luma\SecurityComponent\Form;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Exception\InvalidFieldOptionException;
use Luma\FormComponent\Form\Exception\MissingFieldOptionException;
use Luma\FormComponent\Form\Field\AbstractFormField;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\PasswordInputField;
use Luma\FormComponent\Form\Field\SubmitButton;
use Luma\FormComponent\Form\Field\TextInputField;

class RegistrationForm extends AbstractForm
{
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
            'maxLength' => 60,
        ]));
        $this->addFormField(new EmailInputField([
            'name' => 'emailAddress',
            'id' => 'email-address',
            'label' => 'Email Address',
            'required' => true,
            'placeholder' => 'Email Address',
            'maxLength' => 255,
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'password',
            'id' => 'password',
            'label' => 'Password',
            'required' => true,
            'placeholder' => 'Password',
            'minLength' => 8,
            'validation' => function (AbstractForm $form, AbstractFormField $formField) {
                $hasUpperCase = preg_match('/[A-Z]/', $formField->getValue() ?? '');
                $hasLowerCase = preg_match('/[a-z]/', $formField->getValue() ?? '');
                $hasNumber = preg_match('/[0-9]/', $formField->getValue() ?? '');

                return $hasLowerCase && $hasUpperCase && $hasNumber;
            },
            'validationError' => 'Password must contain at least one upper case character, one lowercase character and one number.',
        ]));
        $this->addFormField(new PasswordInputField([
            'name' => 'repeatPassword',
            'id' => 'repeat-password',
            'label' => 'Repeat Password',
            'required' => true,
            'placeholder' => 'Repeat Password',
            'validation' => function (AbstractForm $form, AbstractFormField $thisField) {
                foreach ($form->getFormFields() as $field) {
                    if ($field->getName() === 'password') {
                        return $field->getValue() === $thisField->getValue();
                    }
                }

                return true;
            },
            'validationError' => 'Passwords do not match',
        ]));
        $this->addFormField(new SubmitButton([
            'name' => 'Register',
            'id' => 'register',
        ]));
    }
}