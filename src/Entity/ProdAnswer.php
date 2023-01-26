<?php

namespace App\Entity;

use App\Repository\ProdAnswerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProdAnswerRepository::class)
 */
class ProdAnswer
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
    private $answer;

    /**
     * @ORM\Column(type="date")
     */
    private $answerDate;

    /**
     * @ORM\ManyToOne(targetEntity=ProdQuestion::class)
     * @ORM\JoinColumn(nullable=false)
     */
    public $fk_questionId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fk_userId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getAnswerDate(): ?\DateTimeInterface
    {
        return $this->answerDate;
    }

    public function setAnswerDate(\DateTimeInterface $answerDate): self
    {
        $this->answerDate = $answerDate;

        return $this;
    }

    public function getFkQuestionId(): ?ProdQuestion
    {
        return $this->fk_questionId;
    }

    public function setFkQuestionId(?ProdQuestion $fk_questionId): self
    {
        $this->fk_questionId = $fk_questionId;

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
}
