<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Asset;

use Symfony\WebpackEncoreBundle\Twig\EntryFilesTwigExtension;

class WebpackEncoreDriver implements AssetDriverInterface
{
    public function __construct(private EntryFilesTwigExtension $encoreExtension) {}

    public function renderStylesheets(array $stylesheets): string
    {
        $html = '';
        foreach ($stylesheets as $entry) {
            $html .= $this->encoreExtension->renderWebpackLinkTags($entry);
        }
        return $html;
    }

    public function renderJavascripts(array $entrypoints): string
    {
        $html = '';
        foreach ($entrypoints as $entry) {
            $html .= $this->encoreExtension->renderWebpackScriptTags($entry);
        }
        return $html;
    }
}
