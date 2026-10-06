<?php

namespace Sonata\AdminBundle\Twig\Extension;
use Sonata\AdminBundle\Asset\AssetDriverInterface;
use Sonata\AdminBundle\SonataConfiguration;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SonataThemeAssetsExtension extends AbstractExtension
{
    public function __construct(
        private SonataConfiguration $sonataConfiguration,
        private AssetDriverInterface $assetDriver // Wstrzyknięty alias sonata.theme.asset_driver
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sonata_theme_render_styles', [$this, 'renderStyles'], ['is_safe' => ['html']]),
            new TwigFunction('sonata_theme_render_scripts', [$this, 'renderScripts'], ['is_safe' => ['html']]),
        ];
    }

    public function renderStyles(): string
    {
        return $this->assetDriver->renderStylesheets($this->sonataConfiguration->getOption('stylesheets', []));
    }

    public function renderScripts(): string
    {
        return $this->assetDriver->renderJavascripts($this->sonataConfiguration->getOption('javascripts', []));
    }
}
