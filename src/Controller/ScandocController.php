<?php

namespace App\Controller;

use App\Entity\Scandoc;
use App\Form\ScandocType;
use App\Repository\ScandocRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/scandoc')]
class ScandocController extends AbstractController
{
    #[Route('/', name: 'app_scandoc_index', methods: ['GET'])]
    public function index(ScandocRepository $scandocRepository): Response
    {
        return $this->render('scandoc/index.html.twig', [
            'scandocs' => $scandocRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scandoc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ScandocRepository $scandocRepository): Response
    {
        $scandoc = new Scandoc();
        $form = $this->createForm(ScandocType::class, $scandoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scandocRepository->save($scandoc, true);

            return $this->redirectToRoute('app_scandoc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scandoc/new.html.twig', [
            'scandoc' => $scandoc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scandoc_show', methods: ['GET'])]
    public function show(Scandoc $scandoc): Response
    {
        return $this->render('scandoc/show.html.twig', [
            'scandoc' => $scandoc,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scandoc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scandoc $scandoc, ScandocRepository $scandocRepository): Response
    {
        $form = $this->createForm(ScandocType::class, $scandoc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scandocRepository->save($scandoc, true);

            return $this->redirectToRoute('app_scandoc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scandoc/edit.html.twig', [
            'scandoc' => $scandoc,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scandoc_delete', methods: ['POST'])]
    public function delete(Request $request, Scandoc $scandoc, ScandocRepository $scandocRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scandoc->getId(), $request->request->get('_token'))) {
            $scandocRepository->remove($scandoc, true);
        }

        return $this->redirectToRoute('app_scandoc_index', [], Response::HTTP_SEE_OTHER);
    }
}
