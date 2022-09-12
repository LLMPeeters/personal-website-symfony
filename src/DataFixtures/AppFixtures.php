<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {}
	
	
    public function load(ObjectManager $manager): void
    {
		$user = new User();
		$user
			->setUsername('Lester')
			->setRoles(['ROLE_ADMIN'])
			->setPassword($this->userPasswordHasher->hashPassword($user, 'ChangeMe'));
		
		$manager->persist($user);
		
        $manager->flush();
    }
}
