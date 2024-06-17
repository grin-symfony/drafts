<?php

namespace App\DataFixtures;

use Carbon\CarbonImmutable;
use App\Entity\Product\FoodProduct;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\ProductPassport;

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
			$pp = new ProductPassport(
				$this->faker->firstName,
				[
					'type1',
					'type2',
					'type3',
				]
			);
			$productPassport = $this->faker->numberBetween(0, 1) ? $pp : null;

            $product = new FoodProduct(
                name: $name,
                price: $price,
                description: $description,
                isPublic: $isPublic,
                expiresAt: $expiresAt,
                passport: $productPassport,
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
