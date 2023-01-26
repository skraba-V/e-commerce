<?php

namespace App\Entity;

use App\Repository\ProdQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProdQuestionRepository::class)
 */
class ProdQuestion
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $question;

    /**
     * @ORM\Column(type="date")
     */
    private $questionDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_userId;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_productId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getQuestionDate(): ?\DateTimeInterface
    {
        return $this->questionDate;
    }

    public function setQuestionDate(\DateTimeInterface $questionDate): self
    {
        $this->questionDate = $questionDate;

        return $this;
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
}
