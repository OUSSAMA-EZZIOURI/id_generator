<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    //private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

//    public function user(ValidatorInterface $validator)
//    {
//        $user = new User();
//
//        // ... do something to the $author object
//
//        $errors = $validator->validate($user);
//
//        if (count($errors) > 0) {
//            /*
//             * Uses a __toString method on the $errors variable which is a
//             * ConstraintViolationList object. This gives us a nice string
//             * for debugging.
//             */
//            $errorsString = (string) $errors;
//
//            return new Response($errorsString);
//        }
//
//        return new Response('The user is valid! Yes!');
//    }


    /**
     * @Route("/user/all", name="all_users")
     */
    public function index()
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->render('user/index.html.twig', [
            'title' => 'Utilisateurs',
            'users' => $users,

        ]);
    }

    /**
     * @Route("/user/create", name="create_user")
     * @Route("/user/{id}/edit", name="edit_user")
     *
     */
    public function form(User $user = null, Request $request, ObjectManager $manager)
    {

        //For create_user the user is null
        if (!$user) {
            $user = new User();
            $title = 'Nouveau';
        } else {
            $title = "Edition de l'élément #" . $user->getId();
        }

        //Create the form component
        $form = $this->createFormBuilder($user)
            //->add('create_time')
            ->add('agency', ChoiceType::class, array('choices' => array('Agence 1' => 'Agence 1', 'Agence 2' => 'Agence 2', 'Agence 3' => 'Agence 3', 'Agence 4' => 'Agence 4')))
            ->add('username')
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class)
            ->setAttributes(array(
                'novalidate' => 'novalidate',
            ))
            ->getForm();

        //Analyze the httpRequest
        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                //Check validation in Database level
                //dd($form->getData());
                //$em = $this->getDoctrine()->getManager();
                $user = new User();
                $user->setAgency($form->getData()->getAgency());
                $user->setUsername($form->getData()->getUsername());
                $user->setEmail($form->getData()->getEmail());
                //TODO : set bcrypt hash to user password.
//                $user->setPassword($this->passwordEncoder->encodePassword(
////                    $user,
////                    $form->getData()->getPassword()
////                ));
                $user->setPassword($form->getData()->getPassword());
                if (!$user->getId()) {
                    $user->setCreateTime(new \DateTime());
                }
                $user->setEditTime(new \DateTime());

                $manager->persist($user);
                $manager->flush();
                //return new Response('User is valide');
            }
            return $this->render('user/create.html.twig', ['title' => $title, 'editMode' => $user->getId() !== null, 'formUser' => $form->createView()]);
        }
        return $this->render('user/create.html.twig', ['title' => $title, 'editMode' => $user->getId() !== null, 'formUser' => $form->createView()]);
    }

    /**
     * @Route("/addUser", name="add_user", methods={"POST"})
     */
    public function addUser()
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $em->persist($user);
        $em->flush();
        //dd($request->request->all());
    }
}
