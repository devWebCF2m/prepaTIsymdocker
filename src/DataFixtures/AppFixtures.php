<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory as FakerFactory;
use Cocur\Slugify\Slugify;
use App\Entity\Article;
use App\Entity\Section;
use App\Entity\User;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager): void
    {
        $slugify = new Slugify();
        $faker = FakerFactory::create('fr_FR');

        // admin
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($this->passwordEncoder->hashPassword($user, 'admin'));
        $user->setFullname('Michaël Pitz');
        $user->setEmail($faker->email());
        $manager->persist($user);

        $manager->flush();
    }
}
