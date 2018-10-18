<?php

namespace App\DataFixtures;

use App\Entity\Prefix;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PrefixFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         $prefix = new Prefix();
         $prefix->setPrefix("2018-");
         $manager->persist($prefix);

        $manager->flush();
    }
}
