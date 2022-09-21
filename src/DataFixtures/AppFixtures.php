<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $movie = new Movie();
            $movie
                ->setTitle('Mon film '.$i)
                ->setSynopsys('Mon synopsis... '.$i)
                ->setDuration(rand(80, 200))
                ->setYoutube('Lien Youtube '.$i)
                ->setCover('Mon cover '.$i)
                ->setReleasedAt(new DateTime());
            $manager->persist($movie);
        }
        $manager->flush();
    }
}
