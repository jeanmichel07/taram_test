<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchases')]
    private ?Provider $provider = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalAmount = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, ProductPurchase>
     */
    #[ORM\OneToMany(targetEntity: ProductPurchase::class, mappedBy: 'purchase')]
    private Collection $productPurchases;

    public function __construct()
    {
        $this->productPurchases = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function setProvider(?Provider $provider): static
    {
        $this->provider = $provider;

        return $this;
    }

    public function getTotalAmount(): ?string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): static
    {
        $this->totalAmount = $totalAmount;

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
            $productPurchase->setPurchase($this);
        }

        return $this;
    }

    public function removeProductPurchase(ProductPurchase $productPurchase): static
    {
        if ($this->productPurchases->removeElement($productPurchase)) {
            // set the owning side to null (unless already changed)
            if ($productPurchase->getPurchase() === $this) {
                $productPurchase->setPurchase(null);
            }
        }

        return $this;
    }
}
