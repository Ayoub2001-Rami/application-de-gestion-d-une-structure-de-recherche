<?php

namespace App\Controller;

use App\Repository\ProjetRechercheRepository;
use App\Repository\SujetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    #[Route('/prech', name: 'app_prech')]
    public function prech(ProjetRechercheRepository$repository ): Response
    {
        $prech =$repository->findAll();
        return $this->render('projet/prech.html.twig', [
            'prech' => $prech,
        ]);
    }


    #[Route('/1prech', name: 'app_prech1')]
    public function precheche(Request $request,ProjetRechercheRepository $repository ): Response
    {
        $t=$request->get('year');
        $d=strtotime($t);
        $td=getdate($d);
             $query=$repository->createQueryBuilder('e')
            ->where('e.dateDebut like :dateDebut')
            ->setParameter('dateDebut',$td['year'].'%')
            ->getQuery();
        $prlist=$query->getResult();
        return $this->render('projet/prech.html.twig',array('prech'=>$prlist));
             
    }



	
    #[Route('/sujrech', name: 'app_sujrech')]
    public function sujrech(SujetRechercheRepository $sujetRechercheRepository): Response
    {
        $sujrech=$sujetRechercheRepository->findAll();
        return $this->render('projet/sujrech.html.twig', [
            'sujrech' => $sujrech,
        ]);
    }


    #[Route('/sujdrech', name: 'app_sujrech1')]
    public function sujrecherch(Request $request,SujetRechercheRepository $sujetRechercheRepository): Response
    { 
        $t=$request->get('year');
        $d=strtotime($t);
        $td=getdate($d);
             $query=$sujetRechercheRepository->createQueryBuilder('e')
            ->where('e.datedebut like :datedebut')
            ->setParameter('datedebut',$td['year'].'%')
            ->getQuery();
	    $srlist=$query->getResult();
        return $this->render('projet/sujrech.html.twig',array('sujrech'=>$srlist));
    }



    #[Route('/sujthese', name: 'app_sujthese')]
    public function sujthese(SujetTheseRepository $sujetTRepository ): Response
    {
        $sujthese=$sujetTRepository->findAll();
        return $this->render('projet/sujthese.html.twig', [
            'sujthese' => $sujthese,
        ]);
    }




    #[Route('/sujdthese', name: 'app_sujthese1')]
    public function sujtheserecherche(Request $request,SujetTheseRepository $sujetTRepository ): Response
    {
             $t=$request->get('year');
             $d=strtotime($t);
             $td=getdate($d);
             $query=$sujetTRepository->createQueryBuilder('e')
            ->where('e.annee like :annee')
            ->setParameter('annee',$td['year'].'%')
            ->getQuery();
	    $stlist=$query->getResult();
        return $this->render('projet/sujthese.html.twig',array('sujthese' =>$stlist));
    }





    #[Route('/Result', name: 'liste_Projet_Recherche')]
    public function Recherche(Request $request,  ProjetRechercheRepository $prjRepository)
    {
        // $Request = $this->getRequest();
        $motcle = $request->get('motcle');
        $prech= $prjRepository->findBy(array('titre' => $motcle));
        //$entities  = $this->get('knp_paginator')->paginate(
        //  $Membres,
        // $request->query->get('page', 1)/*page number*/,
        // 6/*limit per page*/
        //);

        return $this->render('projet/prech.html.twig', [
            'prech' => $prech,
        ]);
    }
}
