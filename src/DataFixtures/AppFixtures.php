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
     private Generator $faker;

    public function load(ObjectManager $manager): void
    {
        for($i = 0; $i<5; $i++)
        {
            $volumeCowHerd = new VolumeCowHerd;
            $volumeCowHerd -> setVolume($this->faker->randomFloat(2));
            
        }

           
        $manager->persist($volumeCowHerd);

        $manager->flush();
    }
}
