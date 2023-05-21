<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserRepositoryTest extends KernelTestCase
{
    public function testUsersCount(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $users = $container->get('doctrine')->getRepository(User::class)->count([]);
        $this->assertSame(1, $users);

        // Create a new user
        $newUser = new User();
        $email = microtime(true).'@demo.demo';
        $newUser->setEmail($email);
        $newUser->setRoles(['ROLE_USER']);
        $newUser->setEnabled(true);
        $container->get('doctrine')->getRepository(User::class)->upgradePassword($newUser, 'demo');
        $this->assertTrue($newUser->isEnabled());
        $this->assertSame(['ROLE_USER'], $newUser->getRoles());
        $this->assertSame($email, $newUser->getEmail());
        $this->assertSame($email, $newUser->getUsername());
        $newUser->addRole('ROLE_USER');
        $this->assertSame(['ROLE_USER'], $newUser->getRoles());

        $users = $container->get('doctrine')->getRepository(User::class)->count([]);
        $this->assertSame(2, $users);
        $newUser->setEnabled(false);
        $container->get('doctrine')->getManager()->flush();
        $this->assertFalse($newUser->isEnabled());

        $users = $container->get('doctrine')->getRepository(User::class)->count(['enabled' => true]);
        $this->assertSame(1, $users);
    }

    public function testUpgradePasswordWithInvalidUser(): void
    {
        self::bootKernel();
        $container = self::$kernel->getContainer();
        $this->expectException(UnsupportedUserException::class);

        $user = new class() implements PasswordAuthenticatedUserInterface {
            public function getPassword(): ?string
            {
                return 'demo';
            }
        };
        $container->get('doctrine')->getRepository(User::class)->upgradePassword($user, 'demo');
    }
}
