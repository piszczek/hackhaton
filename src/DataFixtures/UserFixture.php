<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager)
    {
        foreach (
            ['ROLE_ADMIN' => ['admin@orlen.loc'],
            'ROLE_USER' => ['user@orlen.loc']] as $role => $emails) {
            foreach ($emails as $email) {
                $user = new User();
                $user->setEmail($email);
                $user->setRoles([$role]);

                $user->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'password'
                ));

                $manager->persist($user);
            }
        }


        $manager->flush();
    }
}
