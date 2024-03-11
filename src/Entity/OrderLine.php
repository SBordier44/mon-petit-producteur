<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderLineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderLineRepository::class)]
class OrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Order $order = null;

    #[ORM\Embedded(class: Price::class)]
    private ?Price $price = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne]
    private ?Product $product = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
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

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTotalIncludingTaxes(): float
    {
        $unitPrice = $this->price->getUnitPrice() / 100;
        $vat = $unitPrice * $this->price->getVat() / 100;
        return $unitPrice + $vat * $this->quantity;
    }

    public function getTotal(): float
    {
        $unitPrice = $this->price->getUnitPrice() / 100;
        return $unitPrice * $this->quantity;
    }

    public function getTaxesAmount(): float
    {
        $unitPrice = $this->price->getUnitPrice() / 100;
        return $unitPrice * $this->price->getVat() / 100;
    }
}
