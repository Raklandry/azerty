<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\Profil;
use App\Form\ProfilType;
use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'profil_index', methods: ['GET'])]
    public function index(ProfilRepository $profilRepository): Response
    {
        return $this->render('profil/index.html.twig', [
            'profils' => $profilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'profil_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $profil = new Profil();
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // on récupère les images transmises
            $photos = $form->get('photos')->getData();
            
            $profil->setUser($this->getUser());

            // on boucle sur les images
            foreach($photos as $photo){
                // on génère un nouveau nom de fichier
                $fills = md5(uniqid()) . '.' . $photo->guessExtension();

                // on copie le fichier dans le dossier uploads
                $photo->move(
                    $this->getParameter('profil_directory'),
                    $fills
                );

                // on stocke l'image dans la base de données (son nom)
                $image = new Photos();
                $image->setNom($fills);
                $profil->addPhoto($image);
            } 

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profil);
            $entityManager->flush();

            $this->addFlash('message', 'Ajout Profil avec succès');

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/new.html.twig', [
            'profil' => $profil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'profil_show', methods: ['GET'])]
    public function show(Profil $profil): Response
    {
        return $this->render('profil/show.html.twig', [
            'profil' => $profil,
        ]);
    }

    #[Route('/{id}/edit', name: 'profil_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Profil $profil, Photos $photo): Response
    {
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les images transmises
            $photos = $form->get('photos')->getData();
            
            $profil->setUser($this->getUser());

            // on boucle sur les images
            foreach($photos as $photo){
                // on génère un nouveau nom de fichier
                $fills = md5(uniqid()) . '.' . $photo->guessExtension();

                // on copie le fichier dans le dossier uploads
                $photo->move(
                    $this->getParameter('profil_directory'),
                    $fills
                );

                // on stocke l'image dans la base de données (son nom)
                $image = new Photos();
                $image->setNom($fills);
                $profil->addPhoto($image);
            }

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash('message', 'Mis à jour du photo de profil avec succès');

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/edit.html.twig', [
            'profil' => $profil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'profil_delete', methods: ['POST'])]
    public function delete(Request $request, Profil $profil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$profil->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profil_index', [], Response::HTTP_SEE_OTHER);
    }
}
