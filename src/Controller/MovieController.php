<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MovieController extends AbstractController
{
    public $doctrine;
    public $manager;
    public $client;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $manager, HttpClientInterface $client)
    {
        $this->doctrine = $doctrine;
        $this->manager = $manager;
        $this->client = $client;
    }

    #[Route('/categories', name: 'categories')]
    public function categories(): Response
    {
        return $this->render('movie/categories.html.twig');
    }

    #[Route('/movies/list', name: 'movie_list')]
    public function list(): Response
    {
        $movies = $this->doctrine->getRepository(Movie::class)->findAll();
        
        return $this->render('movie/list.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movies/create', name: 'movie_create')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($movie);
            $this->manager->flush();

            return $this->redirectToRoute('movie_show', [ 'id' => $movie->getId() ]);
        }

        return $this->render('movie/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/movies/{id}/show', name: 'movie_show')]
    public function show(Movie $movie, Request $request): Response
    {
        // $comment = new Comments();
        // $commentForm = $this->createForm(CommentsType::class, $comment);

        // $commentForm->handleRequest($request);

        // if ($commentForm->isSubmitted() && $commentForm->isValid()) {
        //     $comment->setMovieId($movie);
            
        //     $this->manager->persist($comment);
        //     $this->manager->flush();
        // }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        //     'commentForm' => $commentForm->createView()
        ]);
    }

    #[Route('/movies/{id}/edit', name: 'movie_edit')]
    public function edit(Request $request, Movie $movie): Response
    {
        // $movieForm = $this->createForm(MoviesType::class, $movie);

        // $movieForm->handleRequest($request);

        // if ($movieForm->isSubmitted() && $movieForm->isValid()) {            
        //     $this->manager->persist($movie);
        //     $this->manager->flush();

        //     return $this->redirectToRoute('movie_show', [
        //         'id' => $movie->getId()
        //     ]);
        // }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
        //     'movieForm' => $movieForm->createView()
        ]);
    }

    #[Route('/movies/{id}/delete', name: 'movie_delete')]
    public function delete(Movie $movie): Response
    {
        $this->manager->remove($movie);
        $this->manager->flush();

        return $this->redirectToRoute('movie_list');
    }
}
