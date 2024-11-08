<?php

namespace Luma\SecurityComponent\Controller;

use Luma\Framework\Controller\LumaController;
use Luma\Framework\Luma;
use Luma\HttpComponent\Request;
use Luma\HttpComponent\Response;
use Luma\SecurityComponent\Form\LoginForm;

class SecurityController extends LumaController
{
    private string $loginTemplate;
    private string $registrationTemplate;
    private string $userClassString;

    public function __construct()
    {
        parent::__construct();

        $this->loginTemplate = Luma::getConfigParam('security.loginTemplate');
        $this->registrationTemplate = Luma::getConfigParam('security.registrationTemplate');
    }

    public function login(Request $request): Response
    {
        $form = new LoginForm([]);

        if ($request->getMethod() === 'POST') {
            // Attempt to log in
            $form = new LoginForm($_POST);
        }

        // Render the login form
        return $this->render(Luma::getConfigParam('security.loginTemplate') ?? '', [
            'form' => $form,
        ]);
    }
}