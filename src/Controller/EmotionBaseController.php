<?php

namespace App\Controller;

use App\Entity\EmotionBase;
use App\Form\EmotionBaseType;
use App\Repository\EmotionBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('/emotion/base')]
final class EmotionBaseController extends AbstractController{
    #[Route(name: 'app_emotion_base_index', methods: ['GET'])]
    public function index(EmotionBaseRepository $emotionBaseRepository): Response
    {
        return $this->render('emotion_base/index.html.twig', [
            'emotion_bases' => $emotionBaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_emotion_base_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emotionBase = new EmotionBase();
        $form = $this->createForm(EmotionBaseType::class, $emotionBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($emotionBase);
            $entityManager->flush();

            return $this->redirectToRoute('app_emotion_base_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emotion_base/new.html.twig', [
            'emotion_base' => $emotionBase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emotion_base_show', methods: ['GET'])]
    public function show(EmotionBase $emotionBase): Response
    {
        return $this->render('emotion_base/show.html.twig', [
            'emotion_base' => $emotionBase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_emotion_base_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmotionBase $emotionBase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmotionBaseType::class, $emotionBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_emotion_base_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('emotion_base/edit.html.twig', [
            'emotion_base' => $emotionBase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_emotion_base_delete', methods: ['POST'])]
    public function delete(Request $request, EmotionBase $emotionBase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emotionBase->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($emotionBase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_emotion_base_index', [], Response::HTTP_SEE_OTHER);
    }
}
