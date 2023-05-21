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

use App\Form\ResetPasswordRequestFormType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ResetPasswordRequestFormTypeTest extends KernelTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'email' => 'demo@demo.demo',
        ];

        $container = self::bootKernel()->getContainer();

        $form = $container->get('form.factory')->create(ResetPasswordRequestFormType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertArrayHasKey('email', $form->all());
        $this->assertSame($formData, $form->getData());
        $this->assertTrue($form->isSubmitted());
    }
}
