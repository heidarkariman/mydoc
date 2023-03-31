<?php

namespace App\Controller;

use App\Entity\ScanformType;
use App\Form\ScanformTypeType;
use App\Repository\ScanformTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/scanformtype')]
class ScanformTypeController extends AbstractController
{
    #[Route('/', name: 'app_scanform_type_index', methods: ['GET'])]
    public function index(ScanformTypeRepository $scanformTypeRepository): Response
    {
        return $this->render('scanform_type/index.html.twig', [
            'scanform_types' => $scanformTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scanform_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ScanformTypeRepository $scanformTypeRepository): Response
    {
        $scanformType = new ScanformType();
        $form = $this->createForm(ScanformTypeType::class, $scanformType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scanformTypeRepository->save($scanformType, true);

            return $this->redirectToRoute('app_scanform_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scanform_type/new.html.twig', [
            'scanform_type' => $scanformType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scanform_type_show', methods: ['GET'])]
    public function show(ScanformType $scanformType): Response
    {
        return $this->render('scanform_type/show.html.twig', [
            'scanform_type' => $scanformType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scanform_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScanformType $scanformType, ScanformTypeRepository $scanformTypeRepository): Response
    {
        $form = $this->createForm(ScanformTypeType::class, $scanformType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scanformTypeRepository->save($scanformType, true);

            return $this->redirectToRoute('app_scanform_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scanform_type/edit.html.twig', [
            'scanform_type' => $scanformType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scanform_type_delete', methods: ['POST'])]
    public function delete(Request $request, ScanformType $scanformType, ScanformTypeRepository $scanformTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scanformType->getId(), $request->request->get('_token'))) {
            $scanformTypeRepository->remove($scanformType, true);
        }

        return $this->redirectToRoute('app_scanform_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
