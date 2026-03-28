<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']]
)]
#[ORM\Table(name: "product", indexes: [
    new ORM\Index(name: "unq_active_sku", columns: ["sku"], options: ["where" => "is_active = true"])
])]
#[ORM\EntityListeners(['App\EntityListener\ProductListener'])]
class Product
{
    #[Groups(['product:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 3)]
    private ?string $price = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(length: 5, nullable: true, options: ['default' => 'PLN'])]
    private ?string $currency = null;

    #[Groups(['product:read', 'product:write'])]
    #[ORM\Column(type: Types::BOOLEAN, nullable: false, options: ['default' => false])]
    private ?bool $isDeleted = null;

    /**
     * @var Collection<int, PriceHistory>
     */
    #[Groups(['product:read'])]
    #[ORM\OneToMany(targetEntity: PriceHistory::class, mappedBy: 'product', cascade: ['persist'], orphanRemoval: true)]
    #[ORM\OrderBy(['timestamp' => 'DESC'])]
    private Collection $priceHistories;

    public function __construct()
    {
        $this->priceHistories = new ArrayCollection();
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(bool $isDeleted): static
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return Collection<int, PriceHistory>
     */
    public function getPriceHistories(): Collection
    {
        return $this->priceHistories;
    }

    public function addPriceHistory(PriceHistory $priceHistory): static
    {
        if (!$this->priceHistories->contains($priceHistory)) {
            $this->priceHistories->add($priceHistory);
            $priceHistory->setProduct($this);
        }

        return $this;
    }

    public function removePriceHistory(PriceHistory $priceHistory): static
    {
        if ($this->priceHistories->removeElement($priceHistory)) {
            // set the owning side to null (unless already changed)
            if ($priceHistory->getProduct() === $this) {
                $priceHistory->setProduct(null);
            }
        }

        return $this;
    }
}
