<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="all_users")
     */
    public function index()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/newUser", name="new_user")
     */
    public function newUser()
    {
        return $this->render('user/newUser.html.twig');
    }

    /**
     * @Route("/addUser", name="add_user", methods={'POST'})
     */
    public function addUser()
    {
        //$em = $this->getDoctrine()->getManager();
        //$user = new User();
        //dd($request->request->all());
    }
}
