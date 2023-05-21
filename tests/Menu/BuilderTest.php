<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Menu;

use App\Menu\Builder;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BuilderTest extends KernelTestCase
{
    public function testCreateSidebarMenu(): void
    {
        $container = self::bootKernel()->getContainer();
        /** @var Builder $menuBuilder */
        $menuBuilder = $container->get(Builder::class);
        $menu = $menuBuilder->createSidebarMenu();
        $this->assertNotEmpty($menu->getChildren());

        $homeMenu = $menu->getChild('Home');
        $this->assertNotNull($homeMenu);
        $this->assertSame('<i class="ph-house"></i><span>menu.label.home</span>', $homeMenu->getLabel());
    }
}
