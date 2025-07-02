<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductPurchase;
use App\Entity\Purchase;
use App\Entity\Stock;
use App\Form\ImportPurchaseType;
use App\Repository\ProductPurchaseRepository;
use App\Repository\ProductRepository;
use App\Repository\PurchaseRepository;
use App\Repository\StockRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/purchase')]
final class PurchaseController extends AbstractController
{
    public function __construct(
        public ProductPurchaseRepository $productPurchaseRepository,
        public PurchaseRepository $purchaseRepository,
        public ProductRepository $productRepository,
        public StockRepository $stockRepository
    )
    {
    }

    #[Route('/', name: 'index_purchase')]
    public function index(): Response
    {
        $purchases = $this->purchaseRepository->findAll();
        return $this->render('purchase/index.html.twig', [
            "purchases" => $purchases
        ]);
    }

            #[Route('/export/csv/', name: 'export_list_purchase_csv')]
    public function exportPurchaseListhaCsv(Purchase $purchase): Response
    {
        // Récupérer les données depuis la base de données
        $productPurchase = $this->productPurchaseRepository->findAll();

        // Créer le contenu du CSV
        $csvContent = [];
        $csvContent[] = ['Product', 'Date d\'achat', 'Quantity', 'UnitPrice', 'TotalPrice']; // En-têtes du CSV

        foreach ($productPurchase as $p) {
            $csvContent[] = [
                $p->getProduct() != null ? $p->getProduct()->getName() : "Nouveau produit",
                $p->getCreatedAt()->format("m/d/Y"),
                $p->getQuantity(),
                $p->getUnitPrice(),
                $p->getQuantity() * $p->getUnitPrice(),
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
            'purchase_export_' . date('Y-m-d_His') . '.csv'
        );
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }


    #[Route('/new', name: 'new_purchase')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImportPurchaseType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $provider = $data['provider']; // Fournisseur sélectionné
            $csvFile = $data['csvFile']; // Fichier CSV

            // Traiter le fichier CSV
            $csvData = $this->parseCsv($csvFile->getPathname());
            
            // Créer un nouvel achat
            $purchase = new Purchase();
            $purchase->setProvider($provider);
            $totalAmount = 00;

            foreach ($csvData as $row) {
                $totalAmount += (float)$row["TotalPrice"];
                $product = $this->productRepository->findOneBy(["name"=>$row['Product']]);
                if($product != null) {
                    $stock = $this->stockRepository->findOneBy(["product"=>$product]);

                    if($stock != null){
                        $stock->setQuantity($stock->getQuantity()+$row['Quantity']);
                        $stock->setUpdatedAt(new DateTimeImmutable());
                        $entityManager->persist($stock);
                    }else {
                        $stock = new Stock();
                        $stock->setProduct($product);
                        $stock->setQuantity($stock->getQuantity()+$row['Quantity']);
                        $stock->setUpdatedAt(new DateTimeImmutable());
                        $entityManager->persist($stock);
                    }
                }
            }
            $purchase->setTotalAmount($totalAmount);
            $entityManager->persist($purchase);
            
            foreach($csvData as $row){
                $product = $this->productRepository->findOneBy(["name"=>$row['Product']]);
                $achatProduit = new ProductPurchase();
                $achatProduit->setPurchase($purchase);
                $achatProduit->setProduct($product);
                $achatProduit->setQuantity((int)$row['Quantity']);
                $achatProduit->setUnitPrice((float)$row['UnitPrice']);
                $entityManager->persist($achatProduit);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Achat importé avec succès !');
            return $this->redirectToRoute('index_purchase');
        }

        return $this->render('purchase/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    private function parseCsv(string $filePath): array
    {
        $csvData = [];
        $defaultDelimiter = ','; // Séparateur par défaut
    
        // Ouvrir le fichier pour détecter le séparateur
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Lire la première ligne pour détecter le séparateur
            $firstLine = fgets($handle);
            rewind($handle); // Remettre le pointeur au début du fichier
    
            // Compter les virgules et points-virgules
            $commaCount = substr_count($firstLine, ',');
            $semicolonCount = substr_count($firstLine, ';');
    
            // Choisir le séparateur dominant
            $delimiter = $commaCount >= $semicolonCount ? ',' : ';';
    
            // Lire le CSV avec le séparateur détecté
            $headers = fgetcsv($handle, 1000, $delimiter);
            if ($headers === false) {
                throw new \Exception('Impossible de lire les en-têtes du CSV.');
            }
    
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Vérifier que le nombre de colonnes correspond aux en-têtes
                if (count($row) === count($headers)) {
                    $csvData[] = array_combine($headers, $row);
                } else {
                    // Gérer les lignes mal formatées (optionnel)
                    continue; // Ignore les lignes avec un mauvais nombre de colonnes
                }
            }
            fclose($handle);
        } else {
            throw new \Exception('Impossible d\'ouvrir le fichier CSV.');
        }
    
        return $csvData;
    }

    #[Route('/{id}', name: 'show_purchase')]
    public function show(Purchase $purchase){
        $productPurchase = $this->productPurchaseRepository->findBy(["purchase"=>$purchase]);
        return $this->render('purchase/show.html.twig', [
            "productPurchase"=>$productPurchase,
            "purchase"=>$purchase
        ]);
    }

        #[Route('/export/csv/{id}', name: 'export_purchase_csv')]
    public function exportPurchasehaCsv(Purchase $purchase): Response
    {
        // Récupérer les données depuis la base de données
        $productPurchase = $this->productPurchaseRepository->findBy(["purchase"=>$purchase]);

        // Créer le contenu du CSV
        $csvContent = [];
        $csvContent[] = ['Product', 'Quantity', 'UnitPrice', 'TotalPrice']; // En-têtes du CSV

        foreach ($productPurchase as $p) {
            $csvContent[] = [
                $p->getProduct() != null ? $p->getProduct()->getName() : "Nouveau produit",
                $p->getQuantity(),
                $p->getUnitPrice(),
                $p->getQuantity() * $p->getUnitPrice(),
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
            'purchase_export_' . date('Y-m-d_His') . '.csv'
        );
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }
}
