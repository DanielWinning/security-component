<?php

namespace Luma\SecurityComponent\Controller;

use Luma\Framework\Controller\LumaController;
use Luma\Framework\Luma;
use Luma\HttpComponent\Request;
use Luma\HttpComponent\Response;
use Luma\SecurityComponent\Authentication\AbstractUser;

class SecurityController extends LumaController
{
    private string $loginTemplate;
    private string $registrationTemplate;
    private string $userClassString;

    public function __construct()
    {
        parent::__construct();

        $this->loginTemplate = Luma::getConfigParam('security.loginTemplate');
    }
    public function login(Request $request): Response
    {
        if ($request->getMethod() === 'POST') {
            // Attempt to log in

        }

        // Render the login form
        return $this->render(Luma::getConfigParam('security.loginTemplate') ?? '');
    }
}