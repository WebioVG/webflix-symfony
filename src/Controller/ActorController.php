<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    #[Route('/actors/list', name: 'actor_list')]
    public function index(): Response
    {
        return $this->render('actor/list.html.twig');
    }
}
