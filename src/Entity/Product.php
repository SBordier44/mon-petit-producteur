<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private int $quantity = 0;

    #[ORM\Embedded(class: Price::class)]
    private ?Price $price = null;

    #[ORM\Embedded(class: Image::class)]
    private ?Image $image = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private ?Farm $farm = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): Product
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): Product
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): Product
    {
        $this->image = $image;

        return $this;
    }

    public function getPriceIncludingTaxes(): float
    {
        if ($this->price) {
            $unitPrice = $this->price->getUnitPrice() / 100;
            $vat = $unitPrice * $this->price->getVat() / 100;
            return $unitPrice + $vat;
        }
        return 0.00;
    }

    public function getTaxesAmount(): float
    {
        if ($this->price) {
            $unitPrice = $this->price->getUnitPrice() / 100;
            return $unitPrice * $this->price->getVat() / 100;
        }
        return 0.00;
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function setFarm(?Farm $farm): Product
    {
        $this->farm = $farm;

        return $this;
    }
}
