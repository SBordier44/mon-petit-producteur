<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer extends User
{
    #[ORM\OneToMany(targetEntity: CartItem::class, mappedBy: 'customer', cascade: ['persist'], orphanRemoval: true)]
    private Collection $cart;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'customer')]
    private Collection $orders;

    public function __construct()
    {
        parent::__construct();
        $this->cart = new ArrayCollection();
        $this->orders = new ArrayCollection();
    }

    public function getRoles(): array
    {
        return ['ROLE_CUSTOMER', 'ROLE_USER'];
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCart(): Collection
    {
        return $this->cart;
    }

    public function addToCart(Product $product): void
    {
        $products = $this->cart->filter(fn(CartItem $cartItem) => $cartItem->getProduct() === $product);

        if ($products->count() === 0) {
            $cartItem = (new CartItem())
                ->setQuantity(1)
                ->setProduct($product)
                ->setCustomer($this);

            $this->cart->add($cartItem);
        }

        $products->first()->increaseQuantity();
    }

    public function getTotalCartIncludingTaxes(): float
    {
        return array_sum($this->cart->map(fn(CartItem $cartItem) => $cartItem->getPriceIncludingTaxes())->toArray());
    }

    public function getTotalCartVat(): float
    {
        return array_sum($this->cart->map(fn(CartItem $cartItem) => $cartItem->getTotalAmountTaxes())->toArray());
    }

    public function getTotalCartWithoutTaxes(): float
    {
        return array_sum(
            $this->cart->map(fn(CartItem $cartItem) => $cartItem->getTotalAmountWithoutTaxes())->toArray()
        );
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }
}
