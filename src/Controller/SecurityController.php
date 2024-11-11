<?php

namespace Luma\SecurityComponent\Controller;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\Framework\Controller\LumaController;
use Luma\Framework\Luma;
use Luma\Framework\Messages\FlashMessage;
use Luma\HttpComponent\Request;
use Luma\HttpComponent\Response;
use Luma\SecurityComponent\Form\LoginForm;
use Luma\SecurityComponent\Form\RegistrationForm;
use Luma\SecurityComponent\Session\DatabaseSessionManager;
use Tracy\Debugger;
use Tracy\ILogger;

class SecurityController extends LumaController
{
    private string $loginTemplate;
    private string $registrationTemplate;
    private string $userClass;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->loginTemplate = Luma::getConfigParam('security.loginTemplate') ?? '';
        $this->registrationTemplate = Luma::getConfigParam('security.registrationTemplate') ?? '';
        $this->userClass = Luma::getConfigParam('security.userClass') ?? '';

        $this->validateConfig();
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

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function register(Request $request): Response
    {
        $form = new RegistrationForm();

        if ($request->getMethod() === 'POST') {
            $form = new RegistrationForm($_POST);

            if ($form->validate()) {
                $data = $form->getData();

                try {
                    $existingUserByEmailAddress = $this->userClass::select([$this->userClass::getSecurityIdentifier()])
                        ->whereIs($this->userClass::getSecurityIdentifier(), $data[$this->userClass::getSecurityIdentifier()])
                        ->get();

                    dump($existingUserByEmailAddress);
                    die();
                } catch (\Exception $exception) {
                    $this->addFlashMessage(
                        new FlashMessage('Something went wrong, please try again.'),
                        FlashMessage::ERROR
                    );
                    Debugger::log($exception->getMessage(), ILogger::EXCEPTION);
                }
            } else {
                foreach ($form->getErrors() as $formError) {
                    $this->addFlashMessage(
                        new FlashMessage($formError),
                        FlashMessage::ERROR
                    );

                    return $this->render($this->registrationTemplate, [
                        'form' => $form,
                    ]);
                }
            }
        }

        return $this->render($this->registrationTemplate, [
            'form' => $form,
        ]);
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    private function validateConfig(): void
    {
        if (!class_exists($this->userClass)) {
            throw new \Exception(sprintf('The specified User class could not be found (%s)', $this->userClass));
        }

        if (!is_subclass_of($this->userClass, Aurora::class)) {
            throw new \Exception(sprintf('Your User class must extend Luma\\AuroraDatabase\\Model\\Aurora - User Class: %s', $this->userClass));
        }
    }
}