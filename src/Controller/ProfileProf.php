<?php

namespace App\Controller;

use App\Entity\Membres;
use App\Entity\Professeur;
use App\Entity\ProjetRecherche;
use App\Entity\Publication;
use App\Entity\SujetRecherche;
use App\Entity\SujetThese;
use App\Form\editType;
use App\Form\ProjetType;
use App\Form\PublicationType;
use App\Form\SujetRechercheType;
use App\Form\SujetTheseType;
use App\Repository\DoctorantRepository;
use App\Repository\MasterRepository;
use App\Repository\MembresRepository;
use App\Repository\PostDocRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\ProjetRechercheRepository;
use App\Repository\PublicationRepository;
use App\Repository\StagiaireRepository;
use App\Repository\SujetRechercheRepository;
use App\Repository\SujetTheseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProfileProf extends AbstractController
{

    #[Route('/profileProf', name: 'app_prof')]
    public function index( Request $request,SujetTheseRepository $sujetTheseRepository,
                           SujetRechercheRepository $repository,
                           ProjetRechercheRepository $projetRechercheRepository,
                           ProfesseurRepository $professeurRepository,
                           PublicationRepository $publicationRepository): Response
    {
        //$memb=new Membres();
        $prof=$professeurRepository->findOneBy(["id_membre"=>$this->getUser()]);
        $prech=$projetRechercheRepository->findBy(["coordinateurPrinc"=>$prof->getId()]);
        $sujetR=$repository->findBy(["Encadren"=>$prof->getId()]);
        $sujet=$sujetTheseRepository->findBy(["encadrant"=>$prof->getId()]);
        $publ=$publicationRepository->findBy(["Auteur"=>$prof->getId()]);

        $memb=$this->getUser();
        return $this->render('profile/Prof.html.twig',[
            'use'=>$memb,
            'prech' => $prech,
            'sujetR'=>$sujetR,
            'sujet' => $sujet,
            'publ'=>$publ,
        ]);
        dd();

    }

//////////////////**********SUJET DE THESE*********//////////////////////////




    #[Route('/ajoutST', name: 'app_ajoutST')]
    public function ajoutSujetThese( Request $request, EntityManagerInterface $entityManager,
                                     SujetTheseRepository $sujetTheseRepository,ProfesseurRepository $pr, SluggerInterface $slugger): Response
    {
        $memb=new Membres();
        $memb=$this->getUser();
        $memb=$memb->getId();
        //$prof=new Professeur();
        $prof=$pr->findOneBy(['id_membre'=>$memb]);


        $sjT=new SujetThese();
        $sjT->SetEncadrant($prof);
        $form=$this->createForm(SujetTheseType::class,$sjT);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $pdf=$form->get('PDF')->getData();
            if ($pdf) {
                $originalFilename = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdf->guessExtension();
                try {
                    $pdf->move(
                        $this->getParameter('sujetThese'),
                        $newFilename
                    );

                } catch (FileException $e) {
                }
                $sjT->setPdf($newFilename);
             }
            $form->getData();
            $entityManager->persist($sjT);
            $entityManager->flush();
        }
        return $this->render('profile/ajouteST.html.twig',[
             'form'=>$form->createView(),
        ]);
    }


    //////////////////**********SUJET DE RECHERCHE*********//////////////////////////



    #[Route('/ajoutSR', name: 'app_ajoutSR')]
    public function ajoutSujetR( Request $request,ProfesseurRepository $professeurRepository ,EntityManagerInterface $entityManager,SujetRechercheRepository $sujetRechercheRepository, SluggerInterface $slugger): Response
    {
        $memb=new Membres();
        $memb=$this->getUser();
        $memb=$memb->getId();
        //$prof=new Professeur();
        $prof=$professeurRepository->findOneBy(['id_membre'=>$memb]);

        $SR=new SujetRecherche();
        $SR->SetEncadren($prof);
        $form=$this->createForm(SujetRechercheType::class,$SR);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $pdf=$form->get('PDF')->getData();
            if ($pdf) {
                $originalFilename = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
                 $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdf->guessExtension();
                try {
                    $pdf->move(
                       $this->getParameter('sujetrecherche'),
                       $newFilename
        );

                } catch (FileException $e) {
          }
                $SR->setPdf($newFilename);
                //$SR->setPdf($newFilename);
}
            $form->getData();
            $entityManager->persist($SR);
            $entityManager->flush();
            //$sujetRechercheRepository->add($suj);
        }
        return $this->render('profile/ajouterSR.html.twig',[
            'form'=>$form->createView(),
        ]);
    }



//////////////////**********PROJET DE RECHERCHE*********//////////////////////////




    #[Route('/ajoutPr', name: 'app_ajoutPr')]
    public function ajouterPr( Request $request, EntityManagerInterface $entityManager
        ,ProjetRechercheRepository $projetRechercheRepository,ProfesseurRepository $professeurRepository, SluggerInterface $slugger): Response
    {
        $memb=new Membres();
        $memb=$this->getUser();
        $memb=$memb->getId();
        //$prof=new Professeur();
        $prof=$professeurRepository->findOneBy(['id_membre'=>$memb]);
        $suj=new ProjetRecherche();
        $suj->setCoordinateurPrinc($prof);
        $form=$this->createForm(ProjetType::class,$suj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $pdf=$form->get('PDF')->getData();
            if ($pdf) {
                $originalFilename = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pdf->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $pdf->move(
                        $this->getParameter('projetrecherche'),
                        $newFilename
                    );

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $suj->setPdf($newFilename);
            }
            $form->getData();
            $entityManager->persist($suj);
            $entityManager->flush();

            //$sujetRechercheRepository->add($suj);
        }
        return $this->render('profile/ajouterPR.html.twig',[
            'form'=>$form->createView(),
        ]);
    }



//////////////////**********PUBLICATION*********//////////////////////////



    #[Route('/ajoutPB', name: 'app_publication')]
    public function PostDoc( Request $request, EntityManagerInterface $entityManager,SujetTheseRepository $sujetTheseRepository): Response
    {
        $pub=new Publication();
        $form=$this->createForm(PublicationType::class,$pub);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $form->getData();
            $entityManager->persist($pub);
            $entityManager->flush();


            //$sujetTheseRepository->add($suj);
        }
        return $this->render('profile/ajouterPB.html.twig',[
            'form'=>$form->createView(),
        ]);
    }





    //////////////////**********EDIT DOCTORANT PROFILE*********//////////////////////////


    #[Route('/editd/{id}', name: 'edit_DOCT')]
    public function editD(SluggerInterface $slugger,DoctorantRepository $doctorantRepository,
                          Request $request, Membres $memb, EntityManagerInterface $manager,
                          MembresRepository $membrerepo, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $doct = $doctorantRepository->findOneBy(['id_membre' => $memb->getId()]);

        $form = $this->createForm(EditType::class, $memb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memb = $form->getData();  //create an object of membre entity
            if ($userPasswordHasher->isPasswordValid($memb, $form->getData()->getPassword())) {
                $memb->setPassword(
                    $form->getData()->getPassword()
                );
            }
            $photo = $form->get('photo')->getData();
                  if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $photo->move(
                        $this->getParameter('membre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                   }
                $memb->setImage($newFilename);
            }
            $manager->persist($memb);
            $manager->flush();
            $doct->setNom($memb->getNom());
            $doct->setPrenom($memb->getPrenom());
            $manager->persist($doct);
            $manager->flush();
        }

        return $this->render('profile/editformD.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }

    //////////////////**********EDIT POST DOCT PROFILE*********//////////////////////////


    #[Route('/editp/{id}', name: 'edit_post')]
    public function editP(SluggerInterface $slugger,PostDocRepository $postDocRepository, Request $request, Membres $memb, EntityManagerInterface $manager, MembresRepository $membrerepo, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $doct = $postDocRepository->findOneBy(['id_membre' => $memb->getId()]);

        $form = $this->createForm(EditType::class, $memb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memb = $form->getData();  //create an object of membre entity
            if ($userPasswordHasher->isPasswordValid($memb, $form->getData()->getPassword())) {
                $memb->setPassword(
                    $form->getData()->getPassword()
                );
            }
            $photo = $form->get('photo')->getData();

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
                        $this->getParameter('membre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $memb->setImage($newFilename);
            }
            $manager->persist($memb);
            $manager->flush();
            $doct->setNom($memb->getNom());
            $doct->setPrenom($memb->getPrenom());
            $manager->persist($doct);
            $manager->flush();
        }

        return $this->render('profile/editformP.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }


    //////////////////**********EDIT MASTER PROFILE*********//////////////////////////


    #[Route('/editm/{id}', name: 'edit_mast')]
    public function editM(SluggerInterface $slugger,MasterRepository $masterRepository ,Request $request, Membres $memb, EntityManagerInterface $manager, MembresRepository $membrerepo, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $doct=$masterRepository->findOneBy(['id_membre' => $memb->getId()]);

        $form = $this->createForm(EditType::class, $memb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memb = $form->getData();  //create an object of membre entity
            if ($userPasswordHasher->isPasswordValid($memb, $form->getData()->getPassword())) {
                $memb->setPassword(
                    $form->getData()->getPassword()
                );
            }
            $photo = $form->get('photo')->getData();

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
                        $this->getParameter('membre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $memb->setImage($newFilename);
            }
            $manager->persist($memb);
            $manager->flush();
            $doct->setNom($memb->getNom());
            $doct->setPrenom($memb->getPrenom());
            $manager->persist($doct);
            $manager->flush();
        }

        return $this->render('profile/editformM.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }


    //////////////////**********EDIT STAGIAIRE PROFILE*********//////////////////////////


    #[Route('/edits/{id}', name: 'edit_stag')]
    public function editS(SluggerInterface $slugger,StagiaireRepository $stagiaireRepository, Request $request, Membres $memb, EntityManagerInterface $manager, MembresRepository $membrerepo, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $stag = $stagiaireRepository->findOneBy(['id_membre' =>$memb->getId()]);

        $form = $this->createForm(EditType::class, $memb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memb = $form->getData();  //create an object of membre entity
            if ($userPasswordHasher->isPasswordValid($memb, $form->getData()->getPassword())) {
                $memb->setPassword(
                    $form->getData()->getPassword()
                );
            }
            $photo = $form->get('photo')->getData();

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
                        $this->getParameter('membre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $memb->setImage($newFilename);
            }
            $manager->persist($memb);
            $manager->flush();
            $stag->setNom($memb->getNom());
            $stag->setPrenom($memb->getPrenom());
            $manager->persist($stag);
            $manager->flush();
        }

        return $this->render('profile/editformS.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }


    #[Route('/editR/{id}', name: 'edit_profile')]
    public function edit(SluggerInterface $slugger,ProfesseurRepository $profRepository, Request $request, Membres $memb, EntityManagerInterface $manager, MembresRepository $membrerepo, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $prof = $profRepository->findOneBy(['id_membre' => $memb->getId()]);

        $form = $this->createForm(EditType::class, $memb);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $memb = $form->getData();  //create an object of membre entity
            if ($userPasswordHasher->isPasswordValid($memb, $form->getData()->getPassword())) {
                $memb->setPassword(
                    $form->getData()->getPassword()
                );
            }
            $photo = $form->get('photo')->getData();

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
                        $this->getParameter('membre_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $memb->setImage($newFilename);
            }
            $manager->persist($memb);
            $manager->flush();
            $prof->setNom($memb->getNom());
            $prof->setPrenom($memb->getPrenom());
            $manager->persist($prof);
            $manager->flush();
        }

        return $this->render('profile/editform.html.twig', [
            'edit_form' => $form->createView(),
        ]);
    }

}