<?php

namespace App\Entity;

use App\Repository\CarritocomprasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarritocomprasRepository::class)]
class Carritocompras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\JoinColumn(nullable: false)]
    #[ORM\ManyToOne(targetEntity: Usuarios::class)]
    private ?Usuarios $usuario = null;

    #[ORM\OneToMany(targetEntity: ItemCarrito::class, mappedBy: 'carritocompras', orphanRemoval: true)]
    private Collection $itemCarritos;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $subtotal = null;

    public function __construct()
    {
        $this->itemCarritos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(usuarios $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return Collection<int, ItemCarrito>
     */
    public function getItemCarritos(): Collection
    {
        return $this->itemCarritos;
    }

    public function addItemCarrito(ItemCarrito $itemCarrito): static
    {
        if (!$this->itemCarritos->contains($itemCarrito)) {
            $this->itemCarritos->add($itemCarrito);
            $itemCarrito->setCarritocompras($this);
        }

        return $this;
    }

    public function removeItemCarrito(ItemCarrito $itemCarrito): static
    {
        if ($this->itemCarritos->removeElement($itemCarrito)) {
            // set the owning side to null (unless already changed)
            if ($itemCarrito->getCarritocompras() === $this) {
                $itemCarrito->setCarritocompras(null);
            }
        }

        return $this;
    }

    public function getSubtotal(): ?string
    {
        return $this->subtotal;
    }

    public function setSubtotal(string $subtotal): static
    {
        $this->subtotal = $subtotal;

        return $this;
    }
}
