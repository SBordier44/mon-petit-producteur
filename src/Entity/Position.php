<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Position
{
    #[ORM\Column(type: Types::DECIMAL, precision: 16, scale: 13, nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 16, scale: 13, nullable: true)]
    private ?float $longitude = null;

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): Position
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): Position
    {
        $this->longitude = $longitude;

        return $this;
    }
}
