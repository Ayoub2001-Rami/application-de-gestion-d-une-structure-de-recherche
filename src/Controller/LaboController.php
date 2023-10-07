<?php

namespace App\Controller;

use App\Repository\MembresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LaboController extends AbstractController
{
    #[Route('/labo', name: 'app_labo')]
    public function index(): Response
    {
           $memb=$this->getUser();
        return $this->render('labo/index.html.twig', [
            'controller_name' => 'LaboController',
              'use'=>$memb,
        ]);
    }

/*    #[Route('/labomembre', name: 'app_labo')]
    public function membre(Request $request): Response
    {

        return $this->render('labo/index.html.twig', [

        ]);
    }*/


}

