<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    public function addSuccessFlash(string $message): void
    {
        $this->addFlash('success', $message);
    }

    public function addErrorFlash(string $message): void
    {
        $this->addFlash('danger', $message);
    }

    public function addWarningFlash(string $message): void
    {
        $this->addFlash('warning', $message);
    }
}
