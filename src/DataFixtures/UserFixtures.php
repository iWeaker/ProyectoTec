<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $crypt;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->crypt = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setId("16491121");
        $user->setUsername('Alejandro');
        $user->setLastM("Bringas");
        $user->setLastF("Martinez");
        $user->setImage('default.jpg');
        $user->setCover('default.jpg');
        $user->setPassword(
            $this->crypt->encodePassword($user, "Omegalv100")
        );
        $user->setDateRegister();
        $manager->persist($user);
        $manager->flush();
    }
}
