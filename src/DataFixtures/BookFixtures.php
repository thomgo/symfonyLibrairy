<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Book;
use App\Entity\Category;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      for ($i = 0; $i < 10; $i++) {
        $book = new book();
        $book->setTitle("title$i");
        $book->setAuthor("auteur$i");
        $book->setSummary("summary$i");
        $book->setPublication();
        $book->setAvailability(1);
        $category->setId();
        $book->setCategory();
        $manager->persist($book);
      }

        $manager->flush();
    }
}
