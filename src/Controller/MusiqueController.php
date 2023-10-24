<?php

namespace App\Controller;

use App\Entity\Musique;
use App\Form\MusiqueType;
use App\Repository\MusiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/musique')]
class MusiqueController extends AbstractController
{
    #[Route('/', name: 'app_musique_index', methods: ['GET'])]
    public function index(MusiqueRepository $musiqueRepository): Response
    {
        return $this->render('musique/index.html.twig', [
            'musiques' => $musiqueRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_musique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $musique = new Musique();
        $form = $this->createForm(MusiqueType::class, $musique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($musique);
            $entityManager->flush();

            return $this->redirectToRoute('app_musique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('musique/new.html.twig', [
            'musique' => $musique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_musique_show', methods: ['GET'])]
    public function show(Musique $musique): Response
    {
        return $this->render('musique/show.html.twig', [
            'musique' => $musique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_musique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Musique $musique, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MusiqueType::class, $musique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_musique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('musique/edit.html.twig', [
            'musique' => $musique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_musique_delete', methods: ['POST'])]
    public function delete(Request $request, Musique $musique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($musique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_musique_index', [], Response::HTTP_SEE_OTHER);
    }
}
