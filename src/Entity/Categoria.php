<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0', nullable: true)]
    private ?string $descuento = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecharegistro = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechainicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechafin = null;

    #[ORM\OneToMany(targetEntity: Productos::class, mappedBy: 'categoria')]
    private Collection $productos;

    /**
     * @var ArrayCollection<int, Productos>
     */
    public function __construct()
    {
        $this->productos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescuento(): ?string
    {
        return $this->descuento;
    }

    public function setDescuento(?string $descuento): static
    {
        $this->descuento = $descuento;

        return $this;
    }

    public function getFecharegistro(): ?\DateTimeInterface
    {
        return $this->fecharegistro;
    }

    public function setFecharegistro(?\DateTimeInterface $fecharegistro): static
    {
        $this->fecharegistro = $fecharegistro;

        return $this;
    }

    public function getFechainicio(): ?\DateTimeInterface
    {
        return $this->fechainicio;
    }

    public function setFechainicio(?\DateTimeInterface $fechainicio): static
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    public function getFechafin(): ?\DateTimeInterface
    {
        return $this->fechafin;
    }

    public function setFechafin(?\DateTimeInterface $fechafin): static
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    public function addProducto(Productos $producto): static
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->setCategoria($this);
        }

        return $this;
    }

    public function removeProducto(Productos $producto): static
    {
        if ($this->productos->removeElement($producto)) {

            if ($producto->getCategoria() === $this) {
                $producto->setCategoria(null);
            }
        }

        return $this;
    }
}
