<?php

namespace App\Controller;

use App\Entity\Doctorant;
use App\Entity\Master;
use App\Entity\Membres;
use App\Entity\PostDoc;
use App\Entity\Professeur;
use App\Entity\Stagiaire;
use App\Form\RegistrationFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request,SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new Membres();
        $prof=new Professeur();
        $doc=new Doctorant();
        $mas=new Master();
        $stag=new Stagiaire();
        $post=new PostDoc();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            switch ($user->getType()){
                case 'admin':
                    $roles[] = 'ROLE_Admin';
                    $user->setRoles($roles);
                    break;
                case 'Professeur':
                    $roles[] = 'ROLE_Professeur';
                    $user->setRoles($roles);
                    $prof->setIdMembre($user);
                    $prof->setNom($user->getNom());
                    $prof->setPrenom($user->getPrenom());
                    break;
                case 'Doctorant':
                    $roles[] = 'ROLE_Doctorant';
                    $user->setRoles($roles);
                    $doc->setIdMembre($user);
                    $doc->setNom($user->getNom());
                    $doc->setPrenom($user->getPrenom());
                    break;
                case 'Master':
                    $roles[] = 'ROLE_Master';
                    $user->setRoles($roles);
                    $mas->setIdMembre($user);
                    $mas->setNom($user->getNom());
                    $mas->setPrenom($user->getPrenom());
                    break;
                case 'Stagiaire':
                    $roles[] = 'ROLE_Stagiaire';
                    $user->setRoles($roles);
                    $stag->setIdMembre($user);
                    $stag->setNom($user->getNom());
                    $stag->setPrenom($user->getPrenom());
                    break;
                case 'Post_doc':
                    $roles[] = 'ROLE_PostDoc';
                    $user->setRoles($roles);
                    $post->setIdMembre($user);
                    $post->setNom($user->getNom());
                    $post->setPrenom($user->getPrenom());
                    break;
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
                $user->setImage($newFilename);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            switch ($user->getType()){
                case 'Professeur':
                    $entityManager->persist($prof);
                    $entityManager->flush();
                    break;
                case 'Doctorant':
                    $entityManager->persist($doc);
                    $entityManager->flush();
                    break;
                case 'Master':
                    $entityManager->persist($mas);
                    $entityManager->flush();
                    break;
                case 'Stagiaire':
                    $entityManager->persist($stag);
                    $entityManager->flush();
                    break;
                case 'Post_doc':
                    $entityManager->persist($post);
                    $entityManager->flush();
                    break;
            }


           /* return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );*/

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
