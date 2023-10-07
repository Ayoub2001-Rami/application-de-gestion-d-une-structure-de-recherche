<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Repository\DoctorantRepository;
use App\Repository\ProjetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class doctorantController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/profiledoct', name: 'app_profdoct')]
    public function index( Request $request,SujetTheseRepository $sujetTheseRepository,DoctorantRepository $doctorantRepository,ProjetRechercheRepository $projetRechercheRepository): Response
    {
        $memb=new Membres();
        $doct=$doctorantRepository->findOneBy(["id_membre"=>$this->getUser()]);
        $sujet=$sujetTheseRepository->findBy(["doctorant"=>$doct->getId()]);
        $prech=$projetRechercheRepository->findBy(["id"=>$doct->getId()]);
        $memb=$this->getUser();
        return $this->render('profile/doctorant.html.twig',[
            'use'=>$memb,
            'sujet' => $sujet,
            'prech' => $prech
        ]);
    }
}