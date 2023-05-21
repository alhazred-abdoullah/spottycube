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
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Mime\RawMessage;

class ResetPasswordControllerTest extends WebTestCase
{
    public function testResetPasswordPageIsRendered(): void
    {
        $client = static::createClient();
        $client->request('GET', '/reset-password');

        $this->assertResponseIsSuccessful();
    }

    public function testResetPassword(): void
    {
        $client = static::createClient();
        $client->request('GET', '/reset-password');

        $client->submitForm('reset_password_request_form_submit', [
            'reset_password_request_form[email]' => 'admin@example.com',
        ]);

        $this->assertResponseRedirects('/reset-password/check-email');
        $this->assertEmailCount(1);
        $email = $this->getMailerMessage();
        $this->assertNotNull($email);
        $this->assertEmailHtmlBodyContains($email, 'This link will expire in 1 heure.');
        $client->followRedirect();

        // fetch reset token from email
        $resetToken = $this->getResetTokenFromEmail($email);
        $this->assertNotEmpty($resetToken);

        // reset password
        $client->request('GET', '/reset-password/reset/'.$resetToken);
        $this->assertResponseRedirects('/reset-password/reset');
    }

    private function getResetTokenFromEmail(RawMessage $email): string
    {
        $resetToken = '';
        $crawler = new Crawler($email->toString());
        $crawler->filter('a')->each(function (Crawler $node, $i) use (&$resetToken) {
            $href = (string) $node->attr('href');
            if (preg_match('/reset-password\/reset\/(.*)/', $href, $matches)) {
                $resetToken = $matches[1];
            }
        });

        return $resetToken;
    }
}
