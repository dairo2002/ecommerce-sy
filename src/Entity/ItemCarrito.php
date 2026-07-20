<?php

namespace App\Entity;

use App\Repository\ItemCarritoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemCarritoRepository::class)]
class ItemCarrito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'itemCarritos')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Carritocompras $carritocompras = null;

    #[ORM\ManyToOne(inversedBy: 'itemCarritos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?productos $idproducto = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $subtotal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getCarritocompras(): ?carritocompras
    {
        return $this->carritocompras;
    }

    public function setCarritocompras(?carritocompras $carritocompras): static
    {
        $this->carritocompras = $carritocompras;

        return $this;
    }

    public function getIdproducto(): ?productos
    {
        return $this->idproducto;
    }

    public function setIdproducto(?productos $idproducto): static
    {
        $this->idproducto = $idproducto;

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
