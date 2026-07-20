<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
class Usuarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 50)]
    private ?string $correoelectronico = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $telefono = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecharegistro = null;

    #[ORM\OneToOne(mappedBy: 'usuario', cascade: ['persist', 'remove'])]
    private ?Carritocompras $y = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getCorreoelectronico(): ?string
    {
        return $this->correoelectronico;
    }

    public function setCorreoelectronico(string $correoelectronico): static
    {
        $this->correoelectronico = $correoelectronico;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getFecharegistro(): ?\DateTimeInterface
    {
        return $this->fecharegistro;
    }

    public function setFecharegistro(\DateTimeInterface $fecharegistro): static
    {
        $this->fecharegistro = $fecharegistro;

        return $this;
    }

    public function getY(): ?Carritocompras
    {
        return $this->y;
    }

    public function setY(Carritocompras $y): static
    {
        // set the owning side of the relation if necessary
        if ($y->getUsuario() !== $this) {
            $y->setUsuario($this);
        }

        $this->y = $y;

        return $this;
    }
}
