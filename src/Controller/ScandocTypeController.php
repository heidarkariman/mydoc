<?php

namespace App\Controller;

use App\Entity\ScandocType;
use App\Form\ScandocTypeType;
use App\Repository\ScandocTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/scandoctype')]
class ScandocTypeController extends AbstractController
{
    #[Route('/', name: 'app_scandoc_type_index', methods: ['GET'])]
    public function index(ScandocTypeRepository $scandocTypeRepository): Response
    {
        return $this->render('scandoc_type/index.html.twig', [
            'scandoc_types' => $scandocTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scandoc_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ScandocTypeRepository $scandocTypeRepository): Response
    {
        $scandocType = new ScandocType();
        $form = $this->createForm(ScandocTypeType::class, $scandocType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scandocTypeRepository->save($scandocType, true);

            return $this->redirectToRoute('app_scandoc_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scandoc_type/new.html.twig', [
            'scandoc_type' => $scandocType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scandoc_type_show', methods: ['GET'])]
    public function show(ScandocType $scandocType): Response
    {
        return $this->render('scandoc_type/show.html.twig', [
            'scandoc_type' => $scandocType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scandoc_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ScandocType $scandocType, ScandocTypeRepository $scandocTypeRepository): Response
    {
        $form = $this->createForm(ScandocTypeType::class, $scandocType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $scandocTypeRepository->save($scandocType, true);

            return $this->redirectToRoute('app_scandoc_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('scandoc_type/edit.html.twig', [
            'scandoc_type' => $scandocType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scandoc_type_delete', methods: ['POST'])]
    public function delete(Request $request, ScandocType $scandocType, ScandocTypeRepository $scandocTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scandocType->getId(), $request->request->get('_token'))) {
            $scandocTypeRepository->remove($scandocType, true);
        }

        return $this->redirectToRoute('app_scandoc_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
