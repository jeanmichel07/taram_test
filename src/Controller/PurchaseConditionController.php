<?php

namespace App\Controller;

use App\Entity\PurchaseCondition;
use App\Form\PurchaseConditionForm;
use App\Repository\PurchaseConditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/purchase/condition')]
final class PurchaseConditionController extends AbstractController
{
    #[Route(name: 'app_purchase_condition_index', methods: ['GET'])]
    public function index(PurchaseConditionRepository $purchaseConditionRepository): Response
    {
        return $this->render('purchase_condition/index.html.twig', [
            'purchase_conditions' => $purchaseConditionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_purchase_condition_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $purchaseCondition = new PurchaseCondition();
        $form = $this->createForm(PurchaseConditionForm::class, $purchaseCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($purchaseCondition);
            $entityManager->flush();

            return $this->redirectToRoute('app_purchase_condition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('purchase_condition/new.html.twig', [
            'purchase_condition' => $purchaseCondition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purchase_condition_show', methods: ['GET'])]
    public function show(PurchaseCondition $purchaseCondition): Response
    {
        return $this->render('purchase_condition/show.html.twig', [
            'purchase_condition' => $purchaseCondition,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_purchase_condition_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PurchaseCondition $purchaseCondition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PurchaseConditionForm::class, $purchaseCondition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_purchase_condition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('purchase_condition/edit.html.twig', [
            'purchase_condition' => $purchaseCondition,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_purchase_condition_delete', methods: ['POST'])]
    public function delete(Request $request, PurchaseCondition $purchaseCondition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$purchaseCondition->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($purchaseCondition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_purchase_condition_index', [], Response::HTTP_SEE_OTHER);
    }
}
