<?php

namespace App\DataFixtures;

use App\Type\Product\ProductType;
use Carbon\CarbonImmutable;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use App\Entity\UserPassport;

class UserFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(
        $faker,
        #[Autowire(param: 'app.fixture.users')]
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
            $user = new User(
                passport: $this->getReference(UserPassport::class.$i),
            );

            $manager->persist($user);
        }

        $manager->flush();
    }

    /* DependentFixtureInterface */
    public function getDependencies()
    {
        return [
			UserPassportFixture::class,
		];
    }

    //###> HELPER ###
	
}
