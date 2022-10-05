<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    #[ORM\Column]
    private int $packaging;

    #[ORM\Column]
    private int $label;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Receipt::class)]
    private Collection $receipt;

    #[ORM\Column(length: 3)]
    private string $packagingType;

    #[ORM\Column]
    private float $quantityPerPiece;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ExpeditionItem::class)]
    private Collection $items;

    public function __construct()
    {
        $this->receipt = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

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

    /**
     * @return Collection<int, Receipt>
     */
    public function getReceipt(): Collection
    {
        return $this->receipt;
    }

    public function getPackagingType(): string
    {
        return $this->packagingType;
    }

    public function setPackagingType(string $packagingType): self
    {
        $this->packagingType = $packagingType;

        return $this;
    }

    public function getQuantityPerPiece(): float
    {
        return $this->quantityPerPiece;
    }

    public function setQuantityPerPiece(float $quantityPerPiece): self
    {
        $this->quantityPerPiece = $quantityPerPiece;

        return $this;
    }

    /**
     * @return Collection<int, ExpeditionItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ExpeditionItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setProduct($this);
        }

        return $this;
    }

    public function removeItem(ExpeditionItem $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getProduct() === $this) {
                $item->setProduct(null);
            }
        }

        return $this;
    }
}
