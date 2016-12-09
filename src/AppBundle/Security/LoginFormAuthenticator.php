<?php

namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;


class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{

    private $formFactory;
    private $em;
    private $router;
    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, RouterInterface $router,
        UserPasswordEncoder $passwordEncoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
    }

    //gets called on every request to check to see is someone is attempting to log in
    public function getCredentials(Request $request)
    {
        $isLoginForm = $request->getPathInfo() == '/login' && $request->isMethod('POST');

        if(!$isLoginForm){
            return;
        }

        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);
        $data = $form->getData();

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $data['_username']);

        return $data;
    }

    //SymfonyGuard calls this function directly after the above 'getCredentials' function
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //$credentials == $data from the above 'getCredentials' function
        $username = $credentials['_username'];

        return $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $username]);
    }

    //SymfonyGuard calls this function directly after the above 'getUser' function
    public function checkCredentials($credentials, UserInterface $user)
    {
        //$credentials == $data from 'getCredentials' function
        $password = $credentials['_password'];

        if($this->passwordEncoder->isPasswordValid($user, $password)){
            return true;
        }
        return false;
    }

    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    //SymfonyGuard only calls if user typed in the login url instead of being redirected from somewhere
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}