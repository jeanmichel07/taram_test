<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $purchasePrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $sellingPrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Stock>
     */
    #[ORM\OneToMany(targetEntity: Stock::class, mappedBy: 'prodcut')]
    private Collection $stocks;

    /**
     * @var Collection<int, PurchaseCondition>
     */
    #[ORM\OneToMany(targetEntity: PurchaseCondition::class, mappedBy: 'product')]
    private Collection $purchaseConditions;

    /**
     * @var Collection<int, ProductPurchase>
     */
    #[ORM\OneToMany(targetEntity: ProductPurchase::class, mappedBy: 'product')]
    private Collection $productPurchases;

    public function __construct()
    {
        $this->stocks = new ArrayCollection();
        $this->purchaseConditions = new ArrayCollection();
        $this->productPurchases = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPurchasePrice(): ?string
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(string $purchasePrice): static
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSellingPrice(): ?string
    {
        return $this->sellingPrice;
    }

    public function setSellingPrice(string $sellingPrice): static
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Stock>
     */
    public function getStocks(): Collection
    {
        return $this->stocks;
    }

    public function addStock(Stock $stock): static
    {
        if (!$this->stocks->contains($stock)) {
            $this->stocks->add($stock);
            $stock->setProdcut($this);
        }

        return $this;
    }

    public function removeStock(Stock $stock): static
    {
        if ($this->stocks->removeElement($stock)) {
            // set the owning side to null (unless already changed)
            if ($stock->getProdcut() === $this) {
                $stock->setProdcut(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PurchaseCondition>
     */
    public function getPurchaseConditions(): Collection
    {
        return $this->purchaseConditions;
    }

    public function addPurchaseCondition(PurchaseCondition $purchaseCondition): static
    {
        if (!$this->purchaseConditions->contains($purchaseCondition)) {
            $this->purchaseConditions->add($purchaseCondition);
            $purchaseCondition->setProduct($this);
        }

        return $this;
    }

    public function removePurchaseCondition(PurchaseCondition $purchaseCondition): static
    {
        if ($this->purchaseConditions->removeElement($purchaseCondition)) {
            // set the owning side to null (unless already changed)
            if ($purchaseCondition->getProduct() === $this) {
                $purchaseCondition->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductPurchase>
     */
    public function getProductPurchases(): Collection
    {
        return $this->productPurchases;
    }

    public function addProductPurchase(ProductPurchase $productPurchase): static
    {
        if (!$this->productPurchases->contains($productPurchase)) {
            $this->productPurchases->add($productPurchase);
            $productPurchase->setProduct($this);
        }

        return $this;
    }

    public function removeProductPurchase(ProductPurchase $productPurchase): static
    {
        if ($this->productPurchases->removeElement($productPurchase)) {
            // set the owning side to null (unless already changed)
            if ($productPurchase->getProduct() === $this) {
                $productPurchase->setProduct(null);
            }
        }

        return $this;
    }
}
