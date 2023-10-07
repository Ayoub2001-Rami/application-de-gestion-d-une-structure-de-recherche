<?php

namespace App\Controller;

use App\Entity\Membres;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfileController extends AbstractController{
    #[Route(path: '/profile', name: 'app_Profile')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $membre=$this->getUser()->getRoles();
         switch ($membre[0]){
             case 'ROLE_Admin':
                 return $this->redirectToRoute('app_admin');
                 break;
             case 'ROLE_Professeur':
                 return $this->redirectToRoute('app_prof');
                 break;
             case 'ROLE_Doctorant':
                 return $this->redirectToRoute('app_profdoct');
                 break;
             case 'ROLE_Master':
                 return $this->redirectToRoute('app_profM');
                 break;
             case 'ROLE_Stagiaire':
                 return $this->redirectToRoute('app_profSt');
                 break;
             case 'ROLE_PostDoc':
                 return $this->redirectToRoute('app_profPos');
                 break;}
        return $this->redirectToRoute('app_admin');}

}