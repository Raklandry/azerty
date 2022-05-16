<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\ProduitImages;
use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Form\SearchType;
use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits')]
class ProduitsController extends AbstractController
{
    #[Route('/', name: 'produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository, Request $request): Response
    {
        $data = new SearchData();

        $form = $this->createForm(SearchType::class, $data);
        $form->handleRequest($request);
        
        $produits = $produitsRepository->findSearch($data);

        return $this->render('produits/index.html.twig', [
            'produits' => $produits,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'produits_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les images transmises
            $images = $form->get('ProduitImage')->getData();
            
            $produit->setUser($this->getUser());

            // on boucle sur les images
            foreach($images as $image){
                // on génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // on copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // on stocke l'image dans la base de données (son nom)
                $img = new ProduitImages();
                $img->setNom($fichier);
                $produit->addProduitImage($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            $this->addFlash('message', 'Ajout produit avec succès');

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'produits_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Produits $produit): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les images transmises
            $images = $form->get('ProduitImage')->getData();

            // on boucle sur les images
            foreach($images as $image){
                // on génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();

                // on copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );

                // on stocke l'image dans la base de données (son nom)
                $img = new ProduitImages();
                $img->setNom($fichier);
                $produit->addProduitImage($img);

                
            }

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('message', 'Produit mis à jour');

            return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();

            $this->addFlash('message', 'Suppression avec succès');
        }

        return $this->redirectToRoute('user', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/supprime/image/{id}", name="produit_supprime_image", methods={"DELETE"})
     */
    public function DeleteImage(ProduitImages $image, Request $request){
        $data =  json_decode($request->getContent(), true);

        // On vérifie qsi le token est valide
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])){
            // on récupère le nom de l'image
            $nom = $image->getNom();

            // on supprime le fichier
            unlink($this->getParameter('images_directory').'/'.$nom);

            // on supprime l'entrée de la base
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            $this->addFlash('message', 'Image supprimer');

            // on répond en json
            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
