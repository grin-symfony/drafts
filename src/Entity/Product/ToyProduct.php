<?php

namespace App\Entity\Product;

use App\Repository\ToyProductRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\ProductPassport;

#[ORM\Entity(repositoryClass: ToyProductRepository::class)]
class ToyProduct extends Product
{
    public function __construct(
        ?string $name = null,
        ?string $description = null,
        ?string $price = null,
        bool $isPublic = false,
        ?ProductPassport $passport = null,
        #[ORM\Column]
        private ?int $forKidsMoreThan = null,
    ) {
        parent::__construct(
            name: $name,
            description: $description,
            price: $price,
            isPublic: $isPublic,
            passport: $passport,
        );
    }

    public function getForKidsMoreThan(): ?int
    {
        return $this->forKidsMoreThan;
    }

    public function setForKidsMoreThan(int $forKidsMoreThan): static
    {
        $this->forKidsMoreThan = $forKidsMoreThan;

        return $this;
    }
}
