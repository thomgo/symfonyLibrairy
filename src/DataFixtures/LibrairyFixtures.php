<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Librairy;
use Faker;

class LibrairyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
      for ($i=0; $i < 4; $i++) {
        $librairy = new Librairy();
        $librairy->setName("Bibliothèque $faker->lastName");
        $librairy->setCity($faker->city);
        $manager->persist($librairy);
        $this->addReference("librairy$i", $librairy);
      }
        $manager->flush();
    }
}
