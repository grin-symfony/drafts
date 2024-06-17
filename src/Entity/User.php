<?php

namespace App\Entity;

use App\Entity\MappedSuperclass\UserMappedSuperclass;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use App\Service\CarbonService;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[Groups([
        'app.notifier.admin',
    ])]
    private ?Uuid $id = null;

    public function __construct(
		#[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
		#[ORM\JoinColumn(nullable: false)]
		private ?UserPassport $passport = null,
    ) {
    }

    public function getId(): ?Uuid
    {
		return $this->id;
    }

    public function getPassport(): ?UserPassport
    {
        return $this->passport;
    }

    public function setPassport(UserPassport $passport): static
    {
        $this->passport = $passport;

        return $this;
    }
}
