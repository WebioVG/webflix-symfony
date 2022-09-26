<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Comments;
use App\Entity\Movies;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // for ($i = 0; $i < 10; $i++) { 
        //     ${'category'.$i} = new Categories();
        //     ${'category'.$i}
        //         ->setName($faker->word());
        // }

        for ($j = 0; $j < 20; $j++) {
            $movie = new Movies();
            $movie
                ->setTitle($faker->sentence(rand(1,3)))
                ->setSynopsys($faker->paragraphs(rand(2,4), true))
                ->setDuration(rand(80, 200))
                ->setYoutube($faker->url())
                ->setCover($faker->imageUrl())
                ->setReleasedAt(DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-30 years', '+1 years')));
                // ->setCategoryId(${'category'.rand(1, 10)});
            
            // for ($k = 0; $k < rand(1, 10); $k++) { 
            //     $comment = new Comments();
            //     $comment
            //         ->setMessage($faker->sentence(rand(10, 30)))
            //         ->setNote(rand(0, 5))
            //         ->setMovieId($movie);
            //     $manager->persist($comment);

            //     $movie->addComment($comment);
            // }
            
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
