<?php

namespace App\DataFixtures;

use Carbon\CarbonImmutable;
use App\Entity\Product\FoodProduct;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class FoodProductFixtures extends AbstractFixtures implements FixtureGroupInterface//, DependentFixtureInterface
{
    public function __construct(
        $faker,
        #[Autowire(param: 'app.fixture.product.food')]
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
            $expiresAt = $this->faker->dateTimeBetween(endDate: '+30 years');
            $expiresAt = CarbonImmutable::create($expiresAt);

            $product = new FoodProduct(
                name: $name,
                price: $price,
                description: $description,
                isPublic: $isPublic,
                expiresAt: $expiresAt,
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

    //###< HELPER ###
}
