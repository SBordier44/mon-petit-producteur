<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column]
    private ?string $street = null;

    #[ORM\Column(nullable: true)]
    private ?string $streetSuite = null;

    #[ORM\Column]
    private ?string $city = null;

    #[ORM\Column]
    private ?string $zip = null;

    #[ORM\Column]
    private string $country = 'France';

    #[ORM\Column(nullable: true)]
    private ?string $phone = null;

    #[ORM\Embedded(class: Position::class)]
    private ?Position $position = null;

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getStreetSuite(): ?string
    {
        return $this->streetSuite;
    }

    public function setStreetSuite(?string $streetSuite): Address
    {
        $this->streetSuite = $streetSuite;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Address
    {
        $this->country = $country;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): Address
    {
        $this->phone = $phone;
        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): Address
    {
        $this->position = $position;
        return $this;
    }
}
