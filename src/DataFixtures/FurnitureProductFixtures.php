<?php

namespace App\DataFixtures;

use App\Type\Product\FurnitureProductColorType;
use Carbon\CarbonImmutable;
use App\Entity\Product\FurnitureProduct;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class FurnitureProductFixtures extends AbstractFixtures implements FixtureGroupInterface//, DependentFixtureInterface
{
    public function __construct(
        $faker,
        #[Autowire(param: 'app.fixture.product.furniture')]
        private readonly int $count,
    ) {
        parent::__construct(
            faker: $faker,
        );
    }

    public function load(
        ObjectManager $manager
    ): void {
        for ($i = 0; $i < $this->count; ++$i) {
            $name = $this->faker->name();
            $price = $this->faker->numberBetween(59, 5904);
            $description = $this->faker->text();
            $isPublic = $this->faker->boolean;
            $color = $this->getColor();

            $product = new FurnitureProduct(
                name: $name,
                price: $price,
                description: $description,
                isPublic: $isPublic,
                color: $color,
            );

            $manager->persist($product);
        }

        $manager->flush();
    }

    /* DependentFixtureInterface */
    public function getDependencies()
    {
        return [];
    }

    /* FixtureGroupInterface */
    public static function getGroups(): array
    {
        return [
            'product',
        ];
    }

    //###> HELPER ###

    private function getColor(
        ?int $idx = null,
    ): FurnitureProductColorType {
        $cases = FurnitureProductColorType::cases();
        $count = \count($cases);
        $lastIdx = $count - 1;

        $idx ??= $this->faker->numberBetween(0, $lastIdx);

        return $cases[$idx];
    }

    //###< HELPER ###
}
