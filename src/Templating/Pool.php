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

namespace Sonata\AdminBundle\Templating;

use Symfony\Component\DependencyInjection\ContainerInterface;

final class Pool
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var TemplateRegistryInterface
     */
    private $defaultTemplateRegistry;

    /**
     * @var array <string, TemplateRegistryInterface>
     */
    private $templateRegistries;

    public function __construct(ContainerInterface $container, TemplateRegistryInterface $templateRegistry)
    {
        $this->container = $container;
        $this->defaultTemplateRegistry = $templateRegistry;
    }

    public function getDefault(): TemplateRegistryInterface
    {
        return $this->defaultTemplateRegistry;
    }

    public function createTemplateRegistry(string $name): void
    {
        $templateRegistry = new MutableTemplateRegistry($this->defaultTemplateRegistry->getTemplates());
        $this->templateRegistries[$name] = $templateRegistry;
    }

    public function getTemplateRegistry(string $name = 'default'): TemplateRegistryInterface
    {
        if (isset($this->templateRegistries[$name])) {
            return $this->templateRegistries[$name];
        }

        throw new \Exception('TemplateRegistry does not exist.');
    }

    public function getTemplateRegistries(): array
    {
        return $this->templateRegistries;
    }
}
