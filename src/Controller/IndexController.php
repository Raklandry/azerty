<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use App\Repository\ProfilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProduitsRepository $produits, ProfilRepository $profils): Response
    {
        return $this->render('index/index.html.twig', [
            'produits' => $produits->findFlash(),
            'promo' => $produits->findPromo(),
            'profil' => $profils->findProfil(),                                                                                                                                                                                                                                                                                                     
        ]);
    }
}
