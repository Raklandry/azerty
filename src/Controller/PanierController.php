<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'panier')]
    public function index(SessionInterface $session, ProduitsRepository $produitsRepository): Response
    { 
        $panier = $session->get('panier', []);
        $panierData = [];
        foreach($panier as $id => $quantity){
            $panierData[] = [
                'produit' => $produitsRepository->find($id),
                'quantity' => $quantity,
            ];
        }

        $total = 0;
        
        foreach($panierData as $item){
            $totalItem = $item['produit']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('panier/index.html.twig', [
            'items' => $panierData,
            'total' => $total,
        ]);
    }

    #[Route('/ajout/panier/{id}', name: 'ajout_panier')]
    public function ajout($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }

    #[Route('/Supprimer/panier/{id}', name: 'Supprimer_panier')]
    public function suppre($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('panier');
    }


}
