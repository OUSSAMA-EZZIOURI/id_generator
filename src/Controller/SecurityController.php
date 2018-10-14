<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"POST", "GET"})
     */
    //Request $request,
    public function login(AuthenticationUtils $utils)
    {
        if ($this->getUser())
            //return $this->render('index.html.twig');
            //return new RedirectResponse((new Router())->generate('app_homepage'));
            return $this->redirectToRoute('homepage');

        else {
            $error = $utils->getLastAuthenticationError();
            $lastUsername = $utils->getLastUsername();


            return $this->render('security/login.html.twig', [
                'error' => $error,
                'last_username' => $lastUsername,
            ]);
        }

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {

        //return $this->login();
    }
}
