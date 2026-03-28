<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PriceHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: PriceHistoryRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['product:read']],
    denormalizationContext: ['groups' => ['product:write']]
)]
class PriceHistory
{
    #[Groups(['product:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'priceHistories')]
    private ?Product $product = null;

    #[Groups(['product:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 3)]
    private ?string $oldPrice = null;

    #[Groups(['product:read'])]
    #[ORM\Column(type: Types::DECIMAL, precision: 12, scale: 3)]
    private ?string $newPrice = null;

    #[Groups(['product:read'])]
    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOldPrice(): ?string
    {
        return $this->oldPrice;
    }

    public function setOldPrice(string $oldPrice): static
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    public function getNewPrice(): ?string
    {
        return $this->newPrice;
    }

    public function setNewPrice(string $newPrice): static
    {
        $this->newPrice = $newPrice;

        return $this;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
