<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Entity\Labo;
use App\Entity\Membres;
use App\Entity\Professeur;
use App\Entity\SujetRecherche;
use App\Entity\SujetThese;
use App\Form\EauipmenType;
use App\Form\LaboType;
use App\Form\SujetRechercheType;
use App\Form\SujetTheseType;
use App\Repository\DoctorantRepository;
use App\Repository\EquipmentRepository;
use App\Repository\LaboRepository;
use App\Repository\MembresRepository;
use App\Repository\ProfesseurRepository;
use App\Repository\SujetTheseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $userRole=$this->getUser()->getRoles();
        if($userRole[0]=='ROLE_Admin'){
            return $this->redirectToRoute('app_create');
        }
        return $this->redirectToRoute('app_login');
    }

    #[Route('/create', name: 'app_create')]
    public function create(MembresRepository $membresRepository): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/professeur', name: 'app_professeur')]
    public function professeur(MembresRepository $membresRepository): Response
    {
        $prof=$membresRepository->findBy(["Type"=>"Professeur"]);

        return $this->render('admin/Listinfo.html.twig',[
            "Membres"=>$prof,
        ]);
    }

    #[Route('/doctorant', name: 'app_doctorant')]
    public function doctorant(MembresRepository $membresRepository): Response
    {
        $doc=$membresRepository->findBy(["Type"=>"Doctorant"]);
        return $this->render('admin/Listinfo.html.twig',[
            'Membres'=>$doc,
        ]);
    }

    #[Route('/master', name: 'app_master')]
    public function master(MembresRepository $membresRepository): Response
    {
        $mas=$membresRepository->findBy(["Type"=>"Master"]);
        return $this->render('admin/Listinfo.html.twig',[
            'Membres'=>$mas,
        ]);
    }


    #[Route('/stagiaire', name: 'app_stagiaire')]
    public function stagiaire(MembresRepository $membresRepository): Response
    {
        $sta=$membresRepository->findBy(["Type"=>"Stagiaire"]);
        return $this->render('admin/Listinfo.html.twig',[
            'Membres'=>$sta,
        ]);
    }
    #[Route('/PostDoc', name: 'app_PostDoc')]
    public function PostDoc(MembresRepository $membresRepository): Response
    {

        $post=$membresRepository->findBy(["Type"=>"Post_doc"]);

        return $this->render('admin/Listinfo.html.twig',[
            'Membres'=>$post,
        ]);
    }

    #[Route('/ajoutlabo', name: 'app_ajoutLabo')]
    public function ajoutLabo( Request $request,LaboRepository $laboRepository): Response
    {
        $lab=new Labo();
        $form=$this->createForm(LaboType::class,$lab);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $lab=$form->getData();
            $laboRepository->add($lab);
        }
        return $this->render('admin/ajoueLabo.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/ajoutEq', name: 'app_ajoutEq')]
    public function ajoutEq( Request $request,EquipmentRepository $equipmentRepository , SluggerInterface $slugger): Response
    {
        $eqp=new Equipment();
        $form=$this->createForm(EauipmenType::class,$eqp);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $eqp=$form->getData();

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
                        $this->getParameter('equipment_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $eqp->setImage($newFilename);
            }
            $equipmentRepository->add($eqp);
        }
        return $this->render('admin/ajouterEq.html.twig',[
            'form'=>$form->createView(),
        ]);
    }
}
