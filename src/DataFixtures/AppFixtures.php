<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer des fournisseurs (Providers)
        for ($i = 1; $i <= 5; $i++) {
            $provider = new Provider();
            $provider->setName("Fournisseur $i");
            $provider->setAddress("Address". rand(2, 20));
            $provider->setPhone("03".rand(2,4).rand(111111, 9999999));
            $provider->setEmail("fournisseur$i@email.test");
            $manager->persist($provider);
            $this->addReference("provider_$i", $provider); // Stocker pour référence
        }

        // Créer des Produits (Products)
        for ($i = 1; $i <= 5; $i++) {
            $product = new Product();
            $product->setName("Product $i");
            $product->setDescription("Description pour Produit $i");
            $product->setPurchasePrice(rand(10,60));
            $product->setSellingPrice($product->getPurchasePrice() + rand(5,10));
            $manager->persist($product);
            $this->addReference("product_$i", $product); // Stocker pour référence
        }

        $manager->flush();
    }
}
