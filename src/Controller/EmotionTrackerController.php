<?php

namespace App\Controller;

use App\Entity\Journal;
use App\Entity\Entree;
use App\Form\EntreeType;
use App\Form\RapportType;
use App\Repository\EntreeRepository;
use App\Repository\JournalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tracker')]
class EmotionTrackerController extends AbstractController
{
    // src/Controller/EmotionTrackerController.php

    #[Route('', name: 'app_emotion_tracker_index')]
    public function index(EntreeRepository $entreeRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $entries = $entreeRepo->createQueryBuilder('e')
            ->join('e.journal', 'j')
            ->where('j.utilisateur = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        $emotionCounts = [];

        foreach ($entries as $entry) {
            $emotion = $entry->getEmotion()->getNomEmotion();
            $emotionCounts[$emotion] = ($emotionCounts[$emotion] ?? 0) + 1;
        }

        return $this->render('emotion_tracker/index.html.twig', [
            'emotionLabels' => array_keys($emotionCounts),
            'emotionValues' => array_values($emotionCounts),
        ]);
    }




    #[Route('/new', name: 'app_emotion_tracker_new')]
    public function new(Request $request, EntityManagerInterface $em, JournalRepository $journalRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        $journal = $journalRepo->findOneBy(['utilisateur' => $user]);

        if (!$journal) {
            $journal = new Journal();
            $journal->setUtilisateur($user);
            $em->persist($journal);
        }

        $entree = new Entree();
        $entree->setJournal($journal);
        $entree->setDateHeureEntree(new \DateTime());

        $form = $this->createForm(EntreeType::class, $entree);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entree);
            $em->flush();

            return $this->redirectToRoute('app_emotion_tracker_index');
        }

        return $this->render('emotion_tracker/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/journal', name: 'app_emotion_tracker_journal')]
    public function journal(EntreeRepository $entreeRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        $entries = $entreeRepo->createQueryBuilder('e')
            ->join('e.journal', 'j')
            ->where('j.utilisateur = :user')
            ->setParameter('user', $user)
            ->orderBy('e.dateHeureEntree', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('emotion_tracker/journal.html.twig', [
            'entries' => $entries,
        ]);
    }

    #[Route('/rapport', name: 'app_emotion_tracker_rapport')]
    public function rapport(Request $request, EntreeRepository $entreeRepo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(RapportType::class);
        $form->handleRequest($request);

        $data = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $start = $form->get('startDate')->getData();
            $end = $form->get('endDate')->getData();

            $user = $this->getUser();

            $entries = $entreeRepo->createQueryBuilder('e')
                ->join('e.journal', 'j')
                ->where('j.utilisateur = :user')
                ->andWhere('e.dateHeureEntree BETWEEN :start AND :end')
                ->setParameter('user', $user)
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->getQuery()
                ->getResult();

            $count = count($entries);
            $emotionStats = [];

            foreach ($entries as $entry) {
                $label = $entry->getEmotion()->getNomEmotion();
                $emotionStats[$label] = ($emotionStats[$label] ?? 0) + 1;
            }

            arsort($emotionStats);
            $topEmotion = array_key_first($emotionStats);

            $data = [
                'count' => $count,
                'emotions' => $emotionStats,
                'topEmotion' => $topEmotion,
                'start' => $start,
                'end' => $end,
            ];
        }

        return $this->render('emotion_tracker/rapport.html.twig', [
            'form' => $form->createView(),
            'data' => $data,
        ]);
    }
}
