<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    public $doctrine;
    public $entityManager;
    public $movies;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $doctrine->getManager();
        $this->movies = $doctrine->getRepository(Movie::class)->findAll();
    }

    #[Route('/categories', name: 'categories')]
    public function categories(): Response
    {
        return $this->render('movie/categories.html.twig');
    }

    #[Route('/movies/list', name: 'movie_list')]
    public function list(): Response
    {
        return $this->render('movie/list.html.twig', [
            'movies' => $this->movies
        ]);
    }
}
