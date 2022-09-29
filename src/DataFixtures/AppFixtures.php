<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function load(ObjectManager $manager): void // this is an instance of 'dependancy injection' 🔥🔥🔥
    {
        // $product = new Product();
        // $manager->persist($product);

        $user1 = new User();
        $user1->setEmail('test@email.com');
        $user1->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user1,
                'rootroot'
            )
        );
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('next@email.com');
        $user2->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user2,
                'rootroot'
            )
        );
        $manager->persist($user2);



        $microPost1 = new MicroPost(); // R-click to import class
        $microPost1->setTitle('Welcome to my Symfony App!');
        $microPost1->setText('Welcome to my Symfony App!');
        $microPost1->setCreated(new DateTime()); // import this too!
        $microPost1->setAuthor($user1);
        $manager->persist($microPost1);

        $microPost2 = new MicroPost(); // R-click to import class
        $microPost2->setTitle('Hello again user!');
        $microPost2->setText('Hello again user!');
        $microPost2->setCreated(new DateTime()); // import this too!
        $microPost2->setAuthor($user2);
        $manager->persist($microPost2);

        $microPost3 = new MicroPost(); // R-click to import class
        $microPost3->setTitle('Symfony is ace!');
        $microPost3->setText('Symfony is ace!');
        $microPost3->setCreated(new DateTime()); // import this too!
        $microPost3->setAuthor($user1);
        $manager->persist($microPost3);

        $manager->flush(); // this executes the actual query
    }
}
