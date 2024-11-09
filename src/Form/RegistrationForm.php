<?php

namespace Luma\SecurityComponent\Form;

use Luma\FormComponent\Form\AbstractForm;
use Luma\FormComponent\Form\Field\EmailInputField;
use Luma\FormComponent\Form\Field\PasswordInputField;
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

    protected function build(): void
    {
        dump($this->userClass);
    }
}