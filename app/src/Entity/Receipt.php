<?php

namespace App\Entity;

use App\Repository\ReceiptRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceiptRepository::class)]
class Receipt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $receiptDate;

    #[ORM\Column]
    private int $packaging;

    #[ORM\Column]
    private int $label;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getReceiptDate(): \DateTimeInterface
    {
        return $this->receiptDate;
    }

    public function setReceiptDate(\DateTimeInterface $receiptDate): self
    {
        $this->receiptDate = $receiptDate;

        return $this;
    }

    public function getPackaging(): int
    {
        return $this->packaging;
    }

    public function setPackaging(int $packaging): self
    {
        $this->packaging = $packaging;

        return $this;
    }

    public function getLabel(): int
    {
        return $this->label;
    }

    public function setLabel(int $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
