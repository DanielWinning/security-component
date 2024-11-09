<?php

namespace Luma\SecurityComponent\Controller;

use Luma\Framework\Controller\LumaController;
use Luma\Framework\Luma;
use Luma\Framework\Messages\FlashMessage;
use Luma\HttpComponent\Request;
use Luma\HttpComponent\Response;
use Luma\SecurityComponent\Form\LoginForm;
use Luma\SecurityComponent\Session\DatabaseSessionManager;

class SecurityController extends LumaController
{
    private string $loginTemplate;
    private string $registrationTemplate;
    private string $userClass;

    public function __construct()
    {
        parent::__construct();

        $this->loginTemplate = Luma::getConfigParam('security.loginTemplate') ?? '';
        $this->registrationTemplate = Luma::getConfigParam('security.registrationTemplate') ?? '';
        $this->userClass = Luma::getConfigParam('security.userClass') ?? '';
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function login(Request $request): Response
    {
        $form = new LoginForm([]);

        if ($request->getMethod() === 'POST') {
            $form = new LoginForm($_POST);

            if (!$form->validate()) {
                $this->addFlashMessage(
                    new FlashMessage(sprintf('Something went wrong: %s', implode(' ', $form->getErrors()))),
                    FlashMessage::ERROR
                );

                $this->redirect('/login');
            }

            $loginResult = Luma::getAuthenticator()->authenticate(
                $request->get($this->userClass::getSecurityIdentifier()),
                $request->get('password')
            );

            if ($loginResult->isAuthenticated()) {
                DatabaseSessionManager::regenerate();
                DatabaseSessionManager::setSessionItem('user', $loginResult->getUser());

                $this->addFlashMessage(
                    new FlashMessage('Successfully logged in, welcome back.'),
                    FlashMessage::SUCCESS
                );

                return $this->redirect('/');
            } else {
                $this->addFlashMessage(
                    new FlashMessage('Invalid credentials, please check and try again.'),
                    FlashMessage::ERROR
                );
            }
        }

        return $this->render($this->loginTemplate, [
            'form' => $form,
        ]);
    }

    /**
     * @return Response
     */
    public function logout(): Response
    {
        if ($this->getLoggedInUser()) {
            Luma::getAuthenticator()->logout();

            $this->addFlashMessage(
                new FlashMessage('You have successfully logged out of your account.'),
                FlashMessage::INFO
            );
        }

        return $this->redirect('/login');
    }

    public function register(Request $request)
    {
        if ($request->getMethod() === 'POST') {
            //
        }
    }
}