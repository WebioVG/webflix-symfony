<?php

namespace App\Controller;

use App\Entity\Movies;
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
        $this->movies = $doctrine->getRepository(Movies::class)->findAll();
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

    #[Route('/movies/{id}/show', name: 'movie_show')]
    public function show(Movies $movie): Response
    {
        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }
}
