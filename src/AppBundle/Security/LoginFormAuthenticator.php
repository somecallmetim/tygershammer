<?php

namespace AppBundle\Security;

use AppBundle\Form\LoginForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    private $security;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, RouterInterface $router,
        UserPasswordEncoderInterface $passwordEncoder, Security $security)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->router = $router;
        $this->passwordEncoder = $passwordEncoder;
        $this->security = $security;
    }

    //gets called when $this->supports() determines request came from login page as a post request
    public function getCredentials(Request $request)
    {

        // creates form object which takes data from the http request and turns it into a php object
        $form = $this->formFactory->create(LoginForm::class);
        $form->handleRequest($request);

        // data (in this case username & password) from the http request
            // note: in this context username can either be user's username or email address
        $credentials = $form->getData();

        // sets LAST_USERNAME to the username the user just submitted for easier login next time
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['_username']);

        // $credentials is passed to the getUser() function directly below as $credentials
        return $credentials;
    }

    //SymfonyGuard calls this function directly after the above 'getCredentials' function
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        //$credentials == $credentials from the above 'getCredentials' function
        $username = $credentials['_username'] ?: null;

        // this if-else statement is what allows users to login using either their email or username
            // the checkCredentials() function directly below is called next using $user
        if($user = $this->em->getRepository('AppBundle:User')->findOneBy(['username' => $username])){
            return $user;
        }else{
            $user = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $username]);
            return $user;
        }
    }

    //SymfonyGuard calls this function directly after the above 'getUser' function
    public function checkCredentials($credentials, UserInterface $user)
    {
        //$credentials is the same $credentials returned from 'getCredentials' function
        $password = $credentials['_password'];
        $passwordIsValid = $this->passwordEncoder->isPasswordValid($user, $password);

        // if password if valid, login. Otherwise system throws a invalid credentials message
        if($passwordIsValid){
            return true;
        }
        return false;
    }

    // this function is called on every request to see if this authenticator is needed
        // in previous versions, getCredentials was called on every request. now this is called instead,
        // and getCredentials is only called when supports() returns true
    public function supports(Request $request)
    {
        // if http request is a post request from the 'security_login' route, getCredentials() is called
        return 'security_login' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    // tells the system where to accept login requests from
    protected function getLoginUrl()
    {
        return $this->router->generate('security_login');
    }

    //SymfonyGuard calls this function when another redirect path hasn't already been specified
        // for example, you're not logged in and try to go to a page only admins are allowed to access.
        // SymfonyGuard will automatically direct you to the login page and then automatically take you
        // to the page you were attempting to access before upon successful login (assuming your account
        // has the appropriate privileges).
        // This function is called, for example, when you hit the login button and then successfully login.
    protected function getDefaultSuccessRedirectUrl()
    {
        return $this->router->generate('homepage');
    }
}