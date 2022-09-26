<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Movies;
use App\Form\CommentsType;
use App\Form\MoviesType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    public $doctrine;
    public $manager;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $manager)
    {
        $this->doctrine = $doctrine;
        $this->manager = $manager;
    }

    #[Route('/categories', name: 'categories')]
    public function categories(): Response
    {
        return $this->render('movie/categories.html.twig');
    }

    #[Route('/movies/list', name: 'movie_list')]
    public function list(): Response
    {
        $movies = $this->doctrine->getRepository(Movies::class)->findAll();;
        
        return $this->render('movie/list.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movies/create', name: 'movie_create')]
    public function create(Request $request): Response
    {
        $movie = new Movies();
        $form = $this->createForm(MoviesType::class, $movie);

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
    public function show(Movies $movie, Request $request): Response
    {
        $comment = new Comments();
        $commentForm = $this->createForm(CommentsType::class, $comment);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setMovieId($movie);
            
            $this->manager->persist($comment);
            $this->manager->flush();
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'commentForm' => $commentForm->createView()
        ]);
    }

    #[Route('/movies/{id}/edit', name: 'movie_edit')]
    public function edit(Request $request, Movies $movie): Response
    {
        $movieForm = $this->createForm(MoviesType::class, $movie);

        $movieForm->handleRequest($request);

        if ($movieForm->isSubmitted() && $movieForm->isValid()) {            
            $this->manager->persist($movie);
            $this->manager->flush();

            return $this->redirectToRoute('movie_show', [
                'id' => $movie->getId()
            ]);
        }

        return $this->render('movie/edit.html.twig', [
            'movie' => $movie,
            'movieForm' => $movieForm->createView()
        ]);
    }

    #[Route('/movies/{id}/delete', name: 'movie_delete')]
    public function delete(Movies $movie): Response
    {
        $this->manager->remove($movie);
        $this->manager->flush();

        return $this->redirectToRoute('movie_list');
    }
}
