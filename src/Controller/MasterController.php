<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Repository\MasterRepository;
use App\Repository\ProjetRechercheRepository;
use App\Repository\SujetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MasterController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/profileMaster', name: 'app_profM')]
    public function index( Request $request,SujetRechercheRepository $repository,MasterRepository $masterRepository,ProjetRechercheRepository $projetRechercheRepository): Response
    {
        $master=$masterRepository->findOneBy(["id_membre"=>$this->getUser()]);
        $sujetR=$repository->findBy(["master"=>$master->getId()]);
        $prech=$projetRechercheRepository->findBy(["id"=>$master->getId()]);
        $memb=new Membres();
        $memb=$this->getUser();
        return $this->render('profile/master.html.twig',[
            'use'=>$memb,
            'prech'=>$prech,
            'sujetR'=>$sujetR,
        ]);
    }

}