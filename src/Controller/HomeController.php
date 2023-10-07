<?php

namespace App\Controller;

use App\Repository\LaboRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LaboRepository $laboRepository): Response
    {
        $lab=$laboRepository->findAll();
        return $this->render('template.html.twig',[
            'labo'=>$lab,
        ]);
    }


    #[Route('/log', name: 'home')]
    public function home(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
