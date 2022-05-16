<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Produits;
use App\Entity\User;
use App\Form\MessageType;
use App\Repository\UserRepository;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    #[Route('/messages', name: 'messages')]
    public function index(): Response
    {
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }
    #[Route('/send/{id}', name: 'send')]
    public function send(Request $request, User $user): Response
    {

        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");

            return $this->redirectToRoute("messages");
        }

        return $this->render('messages/send.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/envoyer/{id}', name: 'envoyer')]
    public function envoyer(Request $request, User $user): Response
    {

        $message = new Messages;
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $message->setSender($this->getUser());
            $message->setRecipient($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");

            return $this->redirectToRoute("messages");
        }

        return $this->render('messages/send.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    #[Route('/read/{id}', name: 'read')]
    public function read(Request $request, Messages $message): Response
    {

        $message->setIsRead(True);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();


        $msg = new Messages;

        $form = $this->createForm(MessageType::class, $msg);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $msg->setSender($this->getUser());
            $msg->setRecipient($message->getSender());
            $em = $this->getDoctrine()->getManager();
            $em->persist($msg);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");

            return $this->redirectToRoute("messages");
        }

        return $this->render('messages/read.html.twig', [
            'form' => $form->createView(),
            'message' => $message,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Messages $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();
        $this->addFlash("message", "Message supprimer avec succès.");
        return $this->redirectToRoute("messages");
    }
}
