<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints;

class UserDto
{
    public function __construct(
        #[Constraints\NotBlank(groups: ['strings'], allowNull: true)]
        public ?string $firstName = null,
        #[Constraints\NotBlank(groups: ['strings'], allowNull: true)]
        public ?string $lastName = null,
        #[Constraints\Positive(groups: ['ints'])]
        #[Constraints\MoreThanOrEqual(1, groups: ['ints'])]
        #[Constraints\LessThanOrEqual(200, groups: ['ints'])]
        public ?int $age = null,
    ) {
    }
}
