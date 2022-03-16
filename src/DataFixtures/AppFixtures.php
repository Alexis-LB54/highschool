<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Lesson;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;
    
    public function __construct(UserPasswordHasherInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        // $product = new Product();
        // $manager->persist($product);

        $admin = (new Admin())->setEmail("alexis@lebail.eu")->setLastname("Le Bail")->setFirstname("Alexis")->setRoles(["ROLE_ADMIN"])->setBadgeNumber(30071996);
        $hashPassword = $this->encoder->hashPassword($admin, "alexis");
        $admin->setPassword($hashPassword);
        $manager->persist($admin);

        $lesson = (new Lesson())->setName("économie")->setStartLesson(new DateTime("2021-09-04"))->setEndLesson(new DateTime("2022-07-09"));
        $manager->persist($lesson);

        $student1 = (new User())->setEmail("tata@tata.fr")->setLastname("Madame")->setFirstname("tata")->addPromotion($lesson);
        $hashPassword = $this->encoder->hashPassword($student1, "tata");
        $student1->setPassword($hashPassword);
        $manager->persist($student1);

        $student2 = (new User())->setEmail("toto@toto.fr")->setLastname("Monsieur")->setFirstname("toto")->addPromotion($lesson);
        $hashPassword = $this->encoder->hashPassword($student2, "toto");
        $student2->setPassword($hashPassword);
        $manager->persist($student2);

        $manager->flush();
    }
}
