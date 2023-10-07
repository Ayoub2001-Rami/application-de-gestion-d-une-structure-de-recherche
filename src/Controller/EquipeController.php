<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    #[Route('/Equipe', name: 'app_equipe')]
    public function index(EquipeRepository $equipeRepository): Response
    {
        $Equip=$equipeRepository->findAll();
        return $this->render("labo/index.html.twig", [
            'E' => $Equip
        ]);
    }

    #[Route('/quipe', name: 'app_equipe')]
    public function equipe(Request $request,EntityManagerInterface $entityManager): Response{
        $equipe=new Equipe();
        $form=$this->createForm(EquipeType::class,$equipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $equipe= $form->getData();
            $entityManager->persist($equipe);
            $entityManager->flush();
           return $this->redirectToRoute('app_equipe');
        }
        return $this->render('equipe/equipe.html.twig',
            [
                'form' => $form->createView()
            ]);
    }
}
