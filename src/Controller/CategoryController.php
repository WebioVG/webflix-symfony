<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public $doctrine;
    public $manager;

    public function __construct(ManagerRegistry $doctrine, EntityManagerInterface $manager)
    {
        $this->doctrine = $doctrine;
        $this->manager = $manager;
    }

    #[Route('/categories/list', name: 'category_list')]
    public function list(): Response
    {
        $categories = $this->doctrine->getRepository(Categories::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/categories/create', name: 'category_create')]
    public function create(Request $request): Response
    {
        // $category = new Category();
        // $categoryForm = $this->createForm(CategoriesType::class, $category);

        // $categoryForm->handleRequest($request);

        // if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
        //     $this->manager->persist($category);
        //     $this->manager->flush();

        //     return $this->redirectToRoute('category_list');
        // }

        return $this->render('category/create.html.twig', [
            // 'categoryForm' => $categoryForm->createView()
        ]);
    }
}
