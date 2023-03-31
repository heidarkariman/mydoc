<?php

namespace App\Controller;

use App\Entity\Scanform;
use App\Form\ScanformType;
use App\Repository\ScanformRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/scanform')]
class ScanformController extends AbstractController
{
    #[Route('/', name: 'app_scanform_index', methods: ['GET'])]
    public function index(ScanformRepository $scanformRepository): Response
    {
        return $this->render('scanform/index.html.twig', [
            'scanforms' => $scanformRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scanform_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ScanformRepository $scanformRepository): Response
    {
        $scanform = new Scanform();
        $form = $this->createForm(ScanformType::class, $scanform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scanformRepository->save($scanform, true);

            return $this->redirectToRoute('app_scanform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scanform/new.html.twig', [
            'scanform' => $scanform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scanform_show', methods: ['GET'])]
    public function show(Scanform $scanform): Response
    {
        return $this->render('scanform/show.html.twig', [
            'scanform' => $scanform,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scanform_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scanform $scanform, ScanformRepository $scanformRepository): Response
    {
        $form = $this->createForm(ScanformType::class, $scanform);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scanformRepository->save($scanform, true);

            return $this->redirectToRoute('app_scanform_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scanform/edit.html.twig', [
            'scanform' => $scanform,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scanform_delete', methods: ['POST'])]
    public function delete(Request $request, Scanform $scanform, ScanformRepository $scanformRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scanform->getId(), $request->request->get('_token'))) {
            $scanformRepository->remove($scanform, true);
        }

        return $this->redirectToRoute('app_scanform_index', [], Response::HTTP_SEE_OTHER);
    }
}
