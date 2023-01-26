<?php

namespace App\Entity;

use App\Repository\PaymentMethodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentMethodRepository::class)
 */
class PaymentMethod
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $cardNr;

    /**
     * @ORM\Column(type="date")
     */
    private $validDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_UserId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFkType(): ?PaymentType
    {
        return $this->fk_type;
    }

    public function setFkType(?PaymentType $fk_type): self
    {
        $this->fk_type = $fk_type;

        return $this;
    }

    public function getCardNr(): ?int
    {
        return $this->cardNr;
    }

    public function setCardNr(int $cardNr): self
    {
        $this->cardNr = $cardNr;

        return $this;
    }

    public function getValidDate(): ?\DateTimeInterface
    {
        return $this->validDate;
    }

    public function setValidDate(\DateTimeInterface $validDate): self
    {
        $this->validDate = $validDate;

        return $this;
    }

    public function getFkUserId(): ?User
    {
        return $this->fk_UserId;
    }

    public function setFkUserId(?User $fk_UserId): self
    {
        $this->fk_UserId = $fk_UserId;

        return $this;
    }
}
