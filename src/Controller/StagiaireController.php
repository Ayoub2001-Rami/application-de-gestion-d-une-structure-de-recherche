<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Repository\ProjetRechercheRepository;
use App\Repository\StagiaireRepository;
use App\Repository\SujetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StagiaireController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/profileStagiare', name: 'app_profSt')]
    public function index( Request $request,SujetRechercheRepository $repository,StagiaireRepository $stagiaireRepository,ProjetRechercheRepository $projetRechercheRepository): Response
    {
        $stagir=$stagiaireRepository->findOneBy(["id_membre"=>$this->getUser()]);
        $sujetR=$repository->findBy(["Stagiaire"=>$stagir->getId()]);
        $prech=$projetRechercheRepository->findBy(["id"=>$stagir->getId()]);
        $memb=new Membres();
        $memb=$this->getUser();
        return $this->render('profile/stagiaire.html.twig',[
            'use'=>$memb,
            'prech'=>$prech,
            'sujetR'=>$sujetR,
        ]);
    }

}