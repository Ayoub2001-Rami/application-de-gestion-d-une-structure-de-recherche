<?php

namespace App\Controller;

use App\Entity\EVENEMENT;
use App\Form\EventType;
use App\Repository\EVENEMENTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(EVENEMENTRepository $eventrepository): Response
    {
        $events=$eventrepository->findAll();
        return $this->render('event/index.html.twig', [
            'E' => $events
        ]);
    }


    #[Route('/setevent', name: 'set_event')]
    public function event(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $evt = new EVENEMENT();
        $form = $this->createForm(EventType::class, $evt);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $photo = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('eventimage'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $evt->setImage($newFilename);
            }

            $form->getData();
            $entityManager->persist($evt);
            $entityManager->flush();
        }
        return $this->render(view: 'event/eventform.html.twig', parameters: [
            'form' => $form->createView()
        ]);
    }

    #[Route('/event1', name: 'app_event1')]
    public function rechercheyear(Request $request,EVENEMENTRepository  $eventrepository): Response
    {
     $t=$request->get('year');
     $d=strtotime($t);
     $td=getdate($d);
     $query=$eventrepository->createQueryBuilder('e')
         ->where('e.date like :date')
         ->setParameter('date',$td['year'].'%')
         ->getQuery();
       $eventlist=$query->getResult();
        return $this->render(
            'event/index.html.twig',
        array('E'=>$eventlist)
        );
    }




}
