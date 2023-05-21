<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Sign in', [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $this->assertResponseRedirects('/');
        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains('div.example-wrapper', 'Hello');
    }
}
