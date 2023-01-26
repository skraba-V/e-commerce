<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Order;

/**
 * @ORM\Entity(repositoryClass=ShoppingCartRepository::class)
 */
class ShoppingCart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_userId;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $fk_productId;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount = 1;

    /**
     * @ORM\ManyToOne(targetEntity=Order::class, inversedBy="shoppingCarts")
     */
    private $fk_order;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkUserId(): ?User
    {
        return $this->fk_userId;
    }

    public function setFkUserId(?User $fk_userId): self
    {
        $this->fk_userId = $fk_userId;

        return $this;
    }

    public function getFkProductId(): ?Product
    {
        return $this->fk_productId;
    }

    public function setFkProductId(?Product $fk_productId): self
    {
        $this->fk_productId = $fk_productId;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getFkOrder(): ?Order
    {
        return $this->fk_order;
    }

    public function setFkOrder(?Order $fk_order): self
    {
        $this->fk_order = $fk_order;

        return $this;
    }
}
