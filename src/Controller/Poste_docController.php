<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Repository\PostDocRepository;
use App\Repository\ProjetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Poste_docController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/profilePost', name: 'app_profPos')]
    public function index( Request $request,ProjetRechercheRepository $projetRechercheRepository,PostDocRepository $repository): Response
    {
        $post=$repository->findOneBy(["id_membre"=>$this->getUser()]);
        $prech=$projetRechercheRepository->findBy(["id"=>$post->getId()]);
        $memb=new Membres();
        $memb=$this->getUser();
        return $this->render('profile/postdoct.html.twig',[
            'use'=>$memb,
            'prech'=>$prech,
        ]);
    }
}