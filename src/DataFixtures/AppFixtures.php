<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppFixtures extends Fixture
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    public function load(ObjectManager $manager): void
    {
        $moviesResponse = $this->client->request(
            'GET',
            'https://api.themoviedb.org/3/movie/popular?api_key=fc7b957c462178c939f7cdf82141cd58', [
                'verify_peer' => false
            ]
        );
        $movies = $moviesResponse->toArray()['results'];
        
        foreach ($movies as $movie) {
            $movieResponse = $this->client->request(
                'GET',
                'https://api.themoviedb.org/3/movie/'.$movie['id'].'?api_key=fc7b957c462178c939f7cdf82141cd58', [
                    'verify_peer' => false
                ]
            );

            $movieDetail = $movieResponse->toArray();

            $newMovie = new Movie();
            $newMovie
                ->setTitle($movieDetail['original_title'])
                ->setApiId($movieDetail['id'])
                ->setSynopsys($movieDetail['overview'])
                ->setTagline($movieDetail['tagline'] ?? null)
                ->setDuration((int) $movieDetail['runtime'])
                ->setRatingAverage($movieDetail['vote_average'] ?? 0)
                ->setRatingCount($movieDetail['vote_count'] ?? 0)
                ->setReleasedAt(new DateTime($movieDetail['release_date']) ?? null)
                ->setCover('https://image.tmdb.org/t/p/w500'.$movieDetail['poster_path'])
            ;
            $manager->persist($newMovie);
        }


        $manager->flush();
    }
}
