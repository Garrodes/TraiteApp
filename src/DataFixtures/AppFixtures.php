<?php

namespace App\DataFixtures;

use Generator;
use Faker\Factory;
use App\Entity\Cow;
use App\Entity\Breed;
use App\Entity\VolumeCowHerd;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
    //      for($i = 0; $i<5; $i++)
    //    {
    //        $herd = new Breed();
    //        $herd -> setName('race'.$i);
    //        $manager -> persist($herd) ;
    //    }



           


        $manager->flush();
    }
}
