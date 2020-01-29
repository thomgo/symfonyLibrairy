<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\Librairy;
use Faker;


class UserFixtures extends Fixture implements DependentFixtureInterface
{
  private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
      for ($i = 0; $i < 10; $i++) {
        $user = new User();
        $user->setEmail($faker->email);
        $user->setPassword($this->passwordEncoder->encodePassword($user,"mypassword$i"));
        $user->setFirstName($faker->firstName);
        $user->setLastName($faker->lastName);
        $user->setCity($faker->city);
        $user->setCode("code$i");
        $random = mt_rand(0,3);
        $user->setLibrairy($this->getReference("librairy$random"));
        $manager->persist($user);
      }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LibrairyFixtures::class,
        );
    }
}
