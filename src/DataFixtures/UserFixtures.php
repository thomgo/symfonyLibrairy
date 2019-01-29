<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


class UserFixtures extends Fixture
{
  private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
      for ($i = 0; $i < 10; $i++) {
        $user = new User();
        $user->setEmail("mymail$i@gmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword($user,"mypassword$i"));
        $user->setFirstName("firstName$i");
        $user->setLastName("lastName$i");
        $user->setCity("city$i");
        $user->setCode("code$i");
        $manager->persist($user);
      }

        $manager->flush();
    }
}
