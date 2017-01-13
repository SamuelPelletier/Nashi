<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_form")
     */
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');

        // Get the last authentication error, if occured.
        $error = $authUtils->getLastAuthenticationError();

        return $this->render('security/login.html.twig', [
            'auth_error' => $error
        ]);
    }

    /**
     * @Route("/article/admin/auth-check", name="authentication_check")
     */
    public function authenticationCheckAction()
    {
        // This code will never be executed
    }

    /**
     * @Route("/article/admin/logout", name="logout")
     */
    public function logoutaction()
    {
        // This code will never be executed
    }
}