<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Form;

use App\Form\ChangePasswordFormType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChangePasswordFormTypeTest extends KernelTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'plainPassword' => [
                'first' => 'newPassword',
                'second' => 'newPassword',
            ],
        ];

        $container = self::bootKernel()->getContainer();

        $form = $container->get('form.factory')->create(ChangePasswordFormType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertArrayHasKey('plainPassword', $form->all());
        $this->assertSame([], $form->getData());
    }
}
