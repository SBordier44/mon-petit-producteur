<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProducerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProducerRepository::class)]
class Producer extends User
{
    #[ORM\OneToOne(mappedBy: 'producer', cascade: ['persist'])]
    private ?Farm $farm = null;

    public function __construct()
    {
        parent::__construct();
        $this->farm = (new Farm())->setProducer($this);
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function getRoles(): array
    {
        return ['ROLE_PRODUCER', 'ROLE_USER'];
    }

    public function setFarm(Farm $farm): static
    {
        // set the owning side of the relation if necessary
        if ($farm->getProducer() !== $this) {
            $farm->setProducer($this);
        }

        $this->farm = $farm;

        return $this;
    }
}
