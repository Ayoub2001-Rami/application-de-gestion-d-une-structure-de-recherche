<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PubController extends AbstractController
{
    #[Route('/pub', name: 'app_pub')]
    public function index(PublicationRepository $pubrepository): Response
    {
        $pub1=$pubrepository->findAll();
        return $this->render('pub/index.html.twig', [
            'p' => $pub1,
        ]);
    }

    #[Route('/publ', name: 'app_publ')]
    public function publ(Request $request,EntityManagerInterface $entityManager): Response
    {
        //  $us =$this->getUser()->getUserIdentifier();
        $pub = new Publication();
        $form = $this->createForm(PublicationType::class, $pub);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pub = $form->getData();
            $entityManager->persist($pub);
            $entityManager->flush();
            //$sujetTheseRepository->add($suj);
        }
        return $this->render('pub/publ.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/pub1', name: 'app_pub1')]
    public function P_recherche(Request $request,PublicationRepository $pubrepository): Response
    {
        $t=$request->get('year');
        $d=strtotime($t);
        $td=getdate($d);
        $query=$pubrepository->createQueryBuilder('e')
            ->where('e.annee like :annee')
            ->setParameter('annee',$td['year'].'%')
            ->getQuery();
        $publist=$query->getResult();

        return $this->render(
            'pub/index.html.twig',
            array('p'=>$publist));
    }
}