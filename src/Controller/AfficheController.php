<?php

namespace App\Controller;

use  App\Repository\DoctorantRepository;
use App\Repository\ProjetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AfficheController extends AbstractController
{
    #[Route('/affichesr', name: 'app_affiche')]
    public function doctorant(SujetTheseRepository $sujetTheseRepository,DoctorantRepository $doctorantRepository,ProjetRechercheRepository $projetRechercheRepository): Response
    {
        $doct=$doctorantRepository->findOneBy(["id_membre"=>$this->getUser()]);
        $sujet=$sujetTheseRepository->findBy(["id"=>$doct->getId()]);
        $prech=$projetRechercheRepository->findBy(["id"=>$doct->getId()]);
        return $this->render('profile/doctorant.html.twig', [
          //  'sujet' => $sujet,
            'prech' => $prech
        ]);
    }




}
