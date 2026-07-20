<?php

namespace App\DTO\Admin;

use Symfony\Component\Validator\Constraints as Assert;

class ProductDto
{
    public function __construct(
        #[Assert\NotBlank(message: "El nombre no puede ser vacio")]
        public readonly string $nombre,

        #[Assert\NotBlank(message: "La descripción no puede ser vacio")]
        public readonly string $descripcion,

        #[Assert\NotBlank(message: "El stock no puede ser vacio")]
        #[Assert\Positive(message: "El stock debe ser un número positivo")]
        public readonly mixed $stock,

        #[Assert\NotBlank(message: "La imagen es obligatoria")]
        public readonly ?string $imagen,
    ) {}
}
