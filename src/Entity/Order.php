<?php

declare(strict_types=1);

namespace App\Entity;

use App\EventListener\OrderListener;
use App\Repository\OrderRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\EntityListeners([OrderListener::class])]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private ?Uuid $id = null;

    #[ORM\Column]
    private ?string $reference = null;

    #[ORM\Column]
    private string $state = 'created';

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $canceledAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $refusedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $settledAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $acceptedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $processingStartedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $processingCompletedAt = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $deliveredAt = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Farm $farm = null;

    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'order', cascade: ['persist'], orphanRemoval: true)]
    private Collection $lines;

    public function __construct()
    {
        $this->lines = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCanceledAt(): ?DateTimeImmutable
    {
        return $this->canceledAt;
    }

    public function setCanceledAt(?DateTimeImmutable $canceledAt): static
    {
        $this->canceledAt = $canceledAt;

        return $this;
    }

    public function getRefusedAt(): ?DateTimeImmutable
    {
        return $this->refusedAt;
    }

    public function setRefusedAt(?DateTimeImmutable $refusedAt): static
    {
        $this->refusedAt = $refusedAt;

        return $this;
    }

    public function getSettledAt(): ?DateTimeImmutable
    {
        return $this->settledAt;
    }

    public function setSettledAt(?DateTimeImmutable $settledAt): static
    {
        $this->settledAt = $settledAt;

        return $this;
    }

    public function getAcceptedAt(): ?DateTimeImmutable
    {
        return $this->acceptedAt;
    }

    public function setAcceptedAt(?DateTimeImmutable $acceptedAt): static
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    public function getProcessingStartedAt(): ?DateTimeImmutable
    {
        return $this->processingStartedAt;
    }

    public function setProcessingStartedAt(?DateTimeImmutable $processingStartedAt): static
    {
        $this->processingStartedAt = $processingStartedAt;

        return $this;
    }

    public function getProcessingCompletedAt(): ?DateTimeImmutable
    {
        return $this->processingCompletedAt;
    }

    public function setProcessingCompletedAt(?DateTimeImmutable $processingCompletedAt): static
    {
        $this->processingCompletedAt = $processingCompletedAt;

        return $this;
    }

    public function getDeliveredAt(): ?DateTimeImmutable
    {
        return $this->deliveredAt;
    }

    public function setDeliveredAt(?DateTimeImmutable $deliveredAt): static
    {
        $this->deliveredAt = $deliveredAt;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getFarm(): ?Farm
    {
        return $this->farm;
    }

    public function setFarm(?Farm $farm): static
    {
        $this->farm = $farm;

        return $this;
    }

    public function getLines(): Collection
    {
        return $this->lines;
    }

    public function getNumberOfProducts(): int
    {
        return array_sum($this->lines->map(fn(OrderLine $orderLine) => $orderLine->getQuantity())->toArray());
    }

    public function getTotalIncludingTaxes(): float
    {
        return array_sum(
            $this->lines->map(fn(OrderLine $orderLine) => $orderLine->getTotalIncludingTaxes())->toArray()
        );
    }

    public function getTotalWithoutTaxes(): float
    {
        return array_sum(
            $this->lines->map(fn(OrderLine $orderLine) => $orderLine->getTotal())->toArray()
        );
    }

    public function getTotalTaxes(): float
    {
        return array_sum(
            $this->lines->map(fn(OrderLine $orderLine) => $orderLine->getTaxesAmount())->toArray()
        );
    }
}
