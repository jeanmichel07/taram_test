<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Form\ProviderForm;
use App\Repository\ProviderRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/provider')]
final class ProviderController extends AbstractController
{
    #[Route(name: 'app_provider_index', methods: ['GET'])]
    public function index(ProviderRepository $providerRepository): Response
    {
        return $this->render('provider/index.html.twig', [
            'providers' => $providerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_provider_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $provider = new Provider();
        $form = $this->createForm(ProviderForm::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $provider->setCreatedAt(new DateTimeImmutable());
            $entityManager->persist($provider);
            $entityManager->flush();

            return $this->redirectToRoute('app_provider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('provider/new.html.twig', [
            'provider' => $provider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provider_show', methods: ['GET'])]
    public function show(Provider $provider): Response
    {
        return $this->render('provider/show.html.twig', [
            'provider' => $provider,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_provider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Provider $provider, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProviderForm::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_provider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('provider/edit.html.twig', [
            'provider' => $provider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provider_delete', methods: ['POST'])]
    public function delete(Request $request, Provider $provider, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$provider->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($provider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_provider_index', [], Response::HTTP_SEE_OTHER);
    }
}
