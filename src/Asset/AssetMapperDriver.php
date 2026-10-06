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

use Symfony\Component\AssetMapper\ImportMap\ImportMapRenderer;

class AssetMapperDriver implements AssetDriverInterface
{
    public function __construct(
        private ImportMapRenderer $assetMapperExtension
    ) {}

    public function renderStylesheets(array $stylesheets): string
    {
        $html = '';
        foreach ($stylesheets as $url) {
            $html .= sprintf('<link rel="stylesheet" href="%s">' . "\n", $url);
        }
        return $html;
    }

    public function renderJavascripts(array $entrypoints): string
    {
        return $this->assetMapperExtension->render($entrypoints);
    }
}
