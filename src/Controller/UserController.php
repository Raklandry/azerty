<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ModifProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/edit', name: 'user_edit', methods: ['GET','POST'])]
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ModifProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('message', 'Profil mis à jour');


            return $this->redirectToRoute('user');
        }

        return $this->renderForm('user/ModifProfil.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user/edit/mdp', name: 'user_mdp')]
    public function mdp(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();

            /* on vérifie si les 2 mots de passe sont identiques */
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();

                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('user');
            }else{
                $this->addFlash('error', 'les deux mots de passe ne sont pas identiques');
            }
        }
        
        return $this->renderForm('user/ModifMdp.html.twig');
    }
}
