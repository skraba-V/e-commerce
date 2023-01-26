<?php

namespace App\Entity;

use App\Repository\SuppSalesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SuppSalesRepository::class)
 */
class SuppSales
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_productId;

    /**
     * @ORM\ManyToOne(targetEntity=Supplier::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_supplier;

    /**
     * @ORM\Column(type="date")
     */
    private $saleDate;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFkSupplier(): ?Supplier
    {
        return $this->fk_supplier;
    }

    public function setFkSupplier(?Supplier $fk_supplier): self
    {
        $this->fk_supplier = $fk_supplier;

        return $this;
    }

    public function getSaleDate(): ?\DateTimeInterface
    {
        return $this->saleDate;
    }

    public function setSaleDate(\DateTimeInterface $saleDate): self
    {
        $this->saleDate = $saleDate;

        return $this;
    }
}
