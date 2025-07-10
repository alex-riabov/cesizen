<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\UtilisateurInfo;
use App\Repository\UtilisateurInfoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


#[Route('/utilisateur/info')]
final class UtilisateurInfoController extends AbstractController
{
    #[Route(name: 'app_utilisateur_info_index', methods: ['GET'])]
    public function index(UtilisateurInfoRepository $utilisateurInfoRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('utilisateur_info/index.html.twig', [
            'utilisateur_infos' => $utilisateurInfoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_info_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $utilisateurInfo = new UtilisateurInfo();

        $form = $this->createFormBuilder($utilisateurInfo)
            ->add('nomUtilisateur', TextType::class)
            ->add('prenomUtilisateur', TextType::class)
            ->add('dateNaissanceUtilisateur', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => false,
                'expanded' => false,
                'mapped' => false,
                'data' => 'ROLE_USER',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $plainPassword = $form->get('plainPassword')->getData();
            $role = $form->get('roles')->getData();

            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($email);
            $utilisateur->setRoles([$role]);
            $utilisateur->setPassword(
                $passwordHasher->hashPassword($utilisateur, $plainPassword)
            );

            $utilisateurInfo->setUtilisateur($utilisateur);

            $entityManager->persist($utilisateur);
            $entityManager->persist($utilisateurInfo);
            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_info_index');
        }

        return $this->render('utilisateur_info/new.html.twig', [
            'utilisateur_info' => $utilisateurInfo,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/{id}', name: 'app_utilisateur_info_show', methods: ['GET'])]
    public function show(UtilisateurInfo $utilisateurInfo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('utilisateur_info/show.html.twig', [
            'utilisateur_info' => $utilisateurInfo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateur_info_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        UtilisateurInfo $utilisateurInfo,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $utilisateur = $utilisateurInfo->getUtilisateur();
        $form = $this->createFormBuilder($utilisateurInfo)
            ->add('nomUtilisateur', TextType::class)
            ->add('prenomUtilisateur', TextType::class)
            ->add('dateNaissanceUtilisateur', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
                'data' => $utilisateur->getEmail(),
            ])
            ->add('newPassword', PasswordType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => false, // dropdown
                'multiple' => false,
                'data' => $utilisateur->getRoles()[0] ?? 'ROLE_USER',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Update email
            $utilisateur->setEmail($form->get('email')->getData());

            // Update password if provided
            $newPassword = $form->get('newPassword')->getData();
            if ($newPassword) {
                $utilisateur->setPassword(
                    $passwordHasher->hashPassword($utilisateur, $newPassword)
                );
            }

            // Update role
            $utilisateur->setRoles([$form->get('roles')->getData()]);

            $entityManager->flush();

            return $this->redirectToRoute('app_utilisateur_info_index');
        }

        return $this->render('utilisateur_info/edit.html.twig', [
            'utilisateur_info' => $utilisateurInfo,
            'form' => $form->createView(),
        ]);
    }




    #[Route('/{id}', name: 'app_utilisateur_info_delete', methods: ['POST'])]
    public function delete(Request $request, UtilisateurInfo $utilisateurInfo, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete'.$utilisateurInfo->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($utilisateurInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_info_index');
    }
}
