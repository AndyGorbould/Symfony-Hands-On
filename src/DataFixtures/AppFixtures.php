<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void // this is an instance of 'dependancy injection' 🔥🔥🔥
    {
        // $product = new Product();
        // $manager->persist($product);
        $microPost1 = new MicroPost(); // R-click to import class
        $microPost1->setTitle('Welcome to my Symfony App!');
        $microPost1->setText('Welcome to my Symfony App!');
        $microPost1->setCreated(new DateTime()); // import this too!
        $manager->persist($microPost1);

        $microPost2 = new MicroPost(); // R-click to import class
        $microPost2->setTitle('Hello again user!');
        $microPost2->setText('Hello again user!');
        $microPost2->setCreated(new DateTime()); // import this too!
        $manager->persist($microPost2);

        $microPost3 = new MicroPost(); // R-click to import class
        $microPost3->setTitle('Symfony is ace!');
        $microPost3->setText('Symfony is ace!');
        $microPost3->setCreated(new DateTime()); // import this too!
        $manager->persist($microPost3);

        $manager->flush(); // this executes the actual query
    }
}
