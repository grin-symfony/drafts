<?php

namespace App\Entity\Product;

use App\Repository\ProductTypeRepository;
use App\Type\Product\ProductTypes;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\MappedSuperclass;
use App\Service\CarbonService;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'type', type: 'string')]
#[DiscriminatorMap([
    'base_product'          => Product::class,
    ProductTypes::FURNITURE => FurnitureProduct::class,
    ProductTypes::TOY       => ToyProduct::class,
    ProductTypes::FOOD      => FoodProduct::class,
])]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
abstract class Product
{
	use \GS\WebApp\Trait\Doctrine\UpdatedAt;
	use \GS\WebApp\Trait\Doctrine\CreatedAt;
	
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'app.notifier.admin',
    ])]
    protected ?int $id = null;

    #[ORM\Column]
    #[Groups([
        'app.notifier.admin',
    ])]
    protected ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups([
        'app.notifier.admin',
    ])]
    protected ?\DateTimeImmutable $updatedAt = null;

    public function __construct(
        #[ORM\Column(length: 255)]
        #[Groups([
            'app.notifier.admin',
        ])]
        protected ?string $name = null,
        #[ORM\Column(type: Types::TEXT)]
        #[Groups([
            'app.notifier.admin',
        ])]
        protected ?string $description = null,
        #[ORM\Column(length: 255)]
        #[Groups([
            'app.notifier.admin',
        ])]
        protected ?string $price = null,
        #[ORM\Column(options: [
            'default' => false,
        ])]
        #[Groups([
            'app.notifier.admin',
        ])]
        protected bool $isPublic = false,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }
}
