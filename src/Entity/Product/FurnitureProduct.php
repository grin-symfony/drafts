<?php

namespace App\Entity\Product;

use App\Repository\FurnitureProductRepository;
use App\Type\Product\FurnitureProductColorType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Entity\ProductPassport;

#[ORM\Entity(repositoryClass: FurnitureProductRepository::class)]
class FurnitureProduct extends Product
{
    public function __construct(
        ?string $name = null,
        ?string $description = null,
        ?string $price = null,
        bool $isPublic = false,
        ?ProductPassport $passport = null,
        #[ORM\Column(enumType: FurnitureProductColorType::class)]
        private ?FurnitureProductColorType $color = null,
    ) {
          parent::__construct(
              name: $name,
              description: $description,
              price: $price,
              isPublic: $isPublic,
              passport: $passport,
          );
    }

    public function getColor(): ?FurnitureProductColorType
    {
        return $this->color;
    }

    public function setColor(FurnitureProductColorType $color): static
    {
        $this->color = $color;

        return $this;
    }
}
