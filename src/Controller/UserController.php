<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Types\DateTimeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @Route("/user/all", name="all_users")
     * @Security("has_role('ROLE_ADMIN')")
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
     * @Security("has_role('ROLE_ADMIN')")
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
            ->add('email')
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

                $user = new User();
                $user->setAgency($form->getData()->getAgency());
                $user->setUsername($form->getData()->getUsername());
                $user->setEmail($form->getData()->getEmail());
                //$user->setPlainPassword($form->getData()->getPassword());
                //TODO : set bcrypt hash to user password.

                if (!$user->getId()) {
                    $this->hashPassword($user, $form->getData()->getPassword());
                }

                //$this->securityEncoderFactory->getEncoder($user)->encodePassword($user->getPassword(), $user->getSalt());
                $user->setEditTime(new \DateTime());

                $manager->persist($user);
                $manager->flush();
                //return new Response('User is valide');
            }
            return $this->render('user/create.html.twig', ['title' => $title, 'editMode' => $user->getId() !== null, 'formUser' => $form->createView()]);
        }
        return $this->render('user/create.html.twig', ['title' => $title, 'editMode' => $user->getId() !== null, 'formUser' => $form->createView()]);
    }

    public function hashPassword(UserInterface $user, string $plainPassword)
    {
        //$plainPassword = $user->getPlainPassword();
        if (0 === strlen($plainPassword)) {
            return;
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $hashedPassword = $encoder->encodePassword($plainPassword, $user->getSalt());
        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
    }

    /**
     * @Route("/addUser", name="add_user", methods={"POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addUser()
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $em->persist($user);
        $em->flush();
        //dd($request->request->all());
    }




    /*public function hashPassword(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
        //UserInterface $user, string $plainPassword
        //$plainPassword = $user->getPlainPassword();
        if (0 === strlen($this->plainPassword)) {
            return;
        }
        $encoder = $this->encoderFactory->getEncoder($this);
//        if ($encoder instanceof BCryptPasswordEncoder) {
//            $this->setSalt(null);
//        } else {
//            $salt = rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '=');
//            $this->setSalt($salt);
//        }
        $hashedPassword = $encoder->encodePassword($this->plainPassword, $this->getSalt());
        $this->setPassword($hashedPassword);
        $this->eraseCredentials();
    }*/


}
