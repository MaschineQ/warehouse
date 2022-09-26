<?php

namespace App\Entity;

use App\Repository\ExpeditionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpeditionRepository::class)]
class Expedition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $expeditionDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'expedition', targetEntity: ExpeditionItem::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $items;

    private $product;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpeditionDate(): ?\DateTimeInterface
    {
        return $this->expeditionDate;
    }

    public function setExpeditionDate(\DateTimeInterface $expeditionDate): self
    {
        $this->expeditionDate = $expeditionDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, ExpeditionItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param Collection $items
     */
    public function setItems(Collection $items): void
    {
        $this->items = $items;
    }



    public function addItem(ExpeditionItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setExpedition($this);
        }

        return $this;
    }

    public function removeItem(ExpeditionItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getExpedition() === $this) {
                $item->setExpedition(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }


}
