<?php

namespace App\Controller;

use App\Entity\Commente;
use App\Entity\Produits;
use App\Form\CommenteType;
use App\Repository\CommenteRepository;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommenteController extends AbstractController
{
    #[Route('/commente', name: 'commente')]
    public function index(Request $request, CommenteRepository $commenteRepository, UserRepository $user): Response
    {
        $em = $this->getDoctrine()->getManager();
        $commente = new Commente();
        $user = $this->getUser();
        $commente->setUser($user);

        $form = $this->createForm(CommenteType::class, $commente);
        $form->handleRequest($request);
        if (!$this->getUser()) {
            return $this->redirectToRoute('index');
        }
        else if($form->isSubmitted() && $form->isValid()) {
            $em->persist($commente);
            $em->flush();
        }

        $commentes = $commenteRepository->findComs();

        return $this->render('commente/index.html.twig', [
            'form' => $form->createView(),
            'commentes' => $commentes,
            'user' => $user,
        ]);
    }
}
