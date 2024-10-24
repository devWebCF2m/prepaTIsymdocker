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
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFullname('Michaël Pitz');
        $user->setEmail($faker->email());
        $user->setUniqid(uniqid("user_", true));
        $user->setActivate(true);
        $users[] = $user;
        $manager->persist($user);

        // redac
        for ($i=1;$i<=5;$i++){
            $user = new User();
            $user->setUsername('redac'.$i);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'redac'.$i));
            $user->setRoles(['ROLE_REDAC']);
            $user->setFullname($faker->name());
            $user->setEmail($faker->email());
            $user->setUniqid(uniqid("user_", true));
            $user->setActivate(true);
            $users[] = $user;
            $manager->persist($user);
        }

        // user
        for($i=1;$i<=24;$i++){
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'user'.$i));
            $user->setRoles(['ROLE_USER']);
            $user->setFullname($faker->name());
            $user->setEmail($faker->email());
            $user->setUniqid(uniqid("user_", true));
            $hasard = mt_rand(1,4)<4;
            $user->setActivate($hasard);
            $manager->persist($user);
        }

        // Article
        for($i=1;$i<=160;$i++){
            $article = new Article();
            $article->setTitle($faker->sentence(6));
            $article->setText($faker->paragraphs(6, true));
            $article->setTitleSlug($slugify->slugify($article->getTitle()));
            $article->setArticleDateCreate($faker->dateTimeBetween('-6 months'));
            $hasard = mt_rand(1,4)<4;
            $article->setPublished($hasard);
            if($hasard){
                $article->setArticleDatePosted($faker->dateTimeBetween($article->getArticleDateCreate()));
            }
            $articles[] = $article;
            $article->setUser($faker->randomElement($users));
            $manager->persist($article);
        }

        // Section
        for ($i=1;$i<=6;$i++){
            $section = new Section();
            $section->setSectionTitle($faker->sentence(2, true));
            $section->setSectionSlug($slugify->slugify($section->getSectionTitle()));
            $section->setSectionDetail($faker->text(490));
            $hasard = mt_rand(2,40);
            $articlesInSections = $faker->randomElements($articles, $hasard);
            foreach ($articlesInSections as $article){
                $section->addArticle($article);
            }
            $manager->persist($section);
        }

        $manager->flush();
    }
}
