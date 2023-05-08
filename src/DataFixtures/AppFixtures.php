<?php

namespace App\DataFixtures;


use Faker\Factory;
use Faker\Generator;
use App\Entity\Cow;
use App\Entity\Herd;
use App\Entity\User;
use App\Entity\Breed;
use App\Entity\Health;
use App\Entity\FoodUnit;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
   private Generator $faker;

    public function __construction()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
      $admin = new User();
      $admin->setFullName('Admin')
        ->setPseudo(null)
        ->setEmail('master@traiteapp.org')
        ->setRoles(['ROLE_USER','ROLE_ADMIN'])
        ->setPlainPassword('pwd');
      
        $manager->persist($admin);

        $manager->flush();
       /*  // food unit
        $unit = new FoodUnit();
        $unit->setUnit('kg');

        $manager->persist($unit);

        // Breed
        $breed = new Breed();
        $breed ->setName('Cachena');

        $manager->persist($breed);

        // Health

        $health = new Health();
        $health-> setState('En pleine forme');

        $manager->persist($health);


        // Herd 

        $herd = new Herd();
        $herd->setName('Laitier')
            ->setWaterNeededForone(50)
            ->setFoodNeededforone(12)
            ->setRefFoodUnit($unit);
        
            $manager->persist($herd);
        
    
             //Users
      $users = [];
      for($i=0;$i<5;$i++)
      {
        $user = new User();
        $user->setFullName('Jamie Molette'.$i)
            ->setPseudo(mt_rand(0, 1) === 1 ? $this->faker->word() : null)
            ->setEmail($this->faker->email())
            ->setRoles(['ROLE_USER'])
            ->setPlainPassword('password');
        $users[]=$user;
        $manager->persist($user);
      }


      $cow= [];
         for($j = 0; $j<100; $j++)
       {
         $cow = new Cow();
         $cow->setName($this->faker->word())
            ->setIdNat($this->faker->numberBetween(1000,9999))
            ->setDob($this->faker->dateTime())
            ->setBreed($breed)
            ->addHealth($health)
            ->setRefHerd($herd)
            ->setUser($users[mt_rand(0,count($users) -1)]);

            $cows[] = $cow;
            $manager->persist($cow);

       }

       $manager->flush();
       
  
            */ 

    }

}