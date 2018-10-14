<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /*for ($i = 0; $i < 1; $i++) {
            $user = new User();
            $user->setEmail(sprintf('admin@admin.com', $i));
            $user->setFirstName(sprintf('FN %d', $i));
            $user->setLastName(sprintf('LN %d', $i));
            $user->setUsername(sprintf('User %d', $i));
            $user->setAgency(sprintf('Agence %d', $i));
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'user'
            ));
            $manager->persist($user);
        }*/
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setUsername('Administrator');
        $user->setAgency('Global');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'admin2018'
        ));
        $manager->persist($user);
        $manager->flush();

    }
}
