<?php

namespace App\DTO\Admin;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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

        #[Assert\NotNull(message: "La imagen es obligatoria")]
        #[Assert\Image(
            maxSize: "2M",
            maxSizeMessage:"La imagen a sobre pasado el limite (Máximo 2MB)",
            mimeTypes:["image/jepg", "image/jpg", "image/png"],
            mimeTypesMessage:"El formato de la imagen no es valido, Solo se permite  JPG, JPEG o PNG"
        )]
        public readonly ?UploadedFile $imagen,
    ) {}
}
