<?php

namespace App\Entity;

use App\Repository\ProviderRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProviderRepository::class)]
class Provider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, Purchase>
     */
    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'provider')]
    private Collection $purchases;

    /**
     * @var Collection<int, PurchaseCondition>
     */
    #[ORM\OneToMany(targetEntity: PurchaseCondition::class, mappedBy: 'provider')]
    private Collection $purchaseConditions;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->purchaseConditions = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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
     * @return Collection<int, Purchase>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): static
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setProvider($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): static
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getProvider() === $this) {
                $purchase->setProvider(null);
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
            $purchaseCondition->setProvider($this);
        }

        return $this;
    }

    public function removePurchaseCondition(PurchaseCondition $purchaseCondition): static
    {
        if ($this->purchaseConditions->removeElement($purchaseCondition)) {
            // set the owning side to null (unless already changed)
            if ($purchaseCondition->getProvider() === $this) {
                $purchaseCondition->setProvider(null);
            }
        }

        return $this;
    }
}
