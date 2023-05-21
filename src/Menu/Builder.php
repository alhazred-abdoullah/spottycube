<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    private FactoryInterface $factory;

    protected Security $security;
    protected TranslatorInterface $translator;

    public function __construct(FactoryInterface $factory, Security $security, TranslatorInterface $translator)
    {
        $this->factory = $factory;
        $this->security = $security;
        $this->translator = $translator;
    }

    public function createSidebarMenu(): \Knp\Menu\ItemInterface
    {
        $menu = $this->factory->createItem('root');
        // Disable label translation
        $menu->setExtra('translation_domain', false);
        $menu->setChildrenAttribute('class', 'nav nav-sidebar');

        $menu->addChild('Home', [
            'route' => 'home',
            'label' => '<i class="ph-house"></i><span>'.$this->translator->trans('menu.label.home').'</span>',
            'extras' => ['safe_label' => true],
        ])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link')
        ;

        return $menu;
    }
}
