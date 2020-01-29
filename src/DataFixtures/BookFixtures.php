<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Librairy;
use Faker;

class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
      for ($i = 0; $i < 40; $i++) {
        $book = new book();
        $book->setTitle($faker->sentence($nbWords = 6, $variableNbWords = true));
        $book->setAuthor($faker->name);
        $book->setSummary($faker->text);
        $book->setPublication(new \DateTime($faker->date($format = 'Y-m-d', $max = 'now')));
        $book->setAvailability(1);
        $random = mt_rand(0,9);
        $book->setCategory($this->getReference("category$random"));
        $random = mt_rand(0,3);
        $book->setLibrairy($this->getReference("librairy$random"));
        $manager->persist($book);
      }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            LibrairyFixtures::class,
        );
    }
}
