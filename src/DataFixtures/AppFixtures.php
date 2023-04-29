<?php

namespace App\DataFixtures;

use Generator;
use Faker\Factory;
use App\Entity\Cow;
use App\Entity\VolumeCowHerd;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        // for($i = 0; $i<5; $i++)
        // {
        //     $volumeCowHerd = new VolumeCowHerd();
        //     $volumeCowHerd -> setVolume(mt_rand(300,900));
        //     $manager->persist($volumeCowHerd);
        // }



           


        $manager->flush();
    }
}
