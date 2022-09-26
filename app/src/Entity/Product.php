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
    private ?int $id = null;

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

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Expedition::class)]
    private Collection $expeditions;

    public function __construct()
    {
        $this->receipt = new ArrayCollection();
        $this->expeditions = new ArrayCollection();
    }

    public function getId(): ?int
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

    /**
     * @return Collection<int, Expedition>
     */
    public function getExpeditions(): Collection
    {
        return $this->expeditions;
    }

    public function addExpedition(Expedition $expedition): self
    {
        if (!$this->expeditions->contains($expedition)) {
            $this->expeditions->add($expedition);
            $expedition->setProduct($this);
        }

        return $this;
    }

    public function removeExpedition(Expedition $expedition): self
    {
        if ($this->expeditions->removeElement($expedition)) {
            // set the owning side to null (unless already changed)
            if ($expedition->getProduct() === $this) {
                $expedition->setProduct(null);
            }
        }

        return $this;
    }
}
