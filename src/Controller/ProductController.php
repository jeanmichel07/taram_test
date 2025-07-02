<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Stock;
use App\Form\ProductForm;
use App\Repository\ProductRepository;
use App\Repository\StockRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product')]
final class ProductController extends AbstractController
{
    #[Route(name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, StockRepository $stockRepository): Response
    {
        $products = $productRepository->findAll();
        $data= [];
        foreach($products as $p){
            $stock = $stockRepository->findOneBy(["product"=>$p]);
            $data [] = [
                "product"=>$p,
                "stock"=>$stock
            ];
        }
        return $this->render('product/index.html.twig', [
            'products' => $data,
        ]);
    }

    #[Route('/export/csv', name: 'export_product_csv')]
    public function exportProductsCsv(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les données depuis la base de données
        $products = $entityManager->getRepository(Product::class)->findAll();

        // Créer le contenu du CSV
        $csvContent = [];
        $csvContent[] = ['Product', 'Quantity', 'UnitPrice', 'TotalPrice']; // En-têtes du CSV

        foreach ($products as $p) {
            $csvContent[] = [
                $p->getName(),
                "",
                $p->getPurchasePrice(),
                "",
            ];
        }

        // Générer le fichier CSV
        $output = fopen('php://temp', 'w+');
        foreach ($csvContent as $row) {
            fputcsv($output, $row, ';'); // Utilise ';' comme délimiteur
        }
        rewind($output);
        $csvString = stream_get_contents($output);
        fclose($output);

        // Créer la réponse HTTP pour le téléchargement
        $response = new Response($csvString);
        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'products_export_' . date('Y-m-d_His') . '.csv'
        );
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            // Stock
            $quantity = $form->get('quantity')->getData();
            $stock = new Stock();
            $stock->setProduct($product);
            $stock->setQuantity($quantity);
            $entityManager->persist($stock);
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
