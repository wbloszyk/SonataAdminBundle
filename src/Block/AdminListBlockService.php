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

namespace Sonata\AdminBundle\Block;

use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Templating\TemplateRegistry;
use Sonata\AdminBundle\Templating\TemplateRegistryInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Environment;

/**
 * @final since sonata-project/admin-bundle 3.52
 *
 * @author Thomas Rabaix <thomas.rabaix@sonata-project.org>
 */
class AdminListBlockService extends AbstractBlockService
{
    /**
     * @var Pool
     */
    protected $pool;

    /**
     * @var TemplateRegistryInterface
     */
    private $templateRegistry;

    /**
     * NEXT_MAJOR: Remove deprecated arguments.
     *
     * @param Environment|EngineInterface|string  $deprecatedNameOrEnvironment
     * @param EngineInterface|null|Pool           $deprecatedEngineOrPool
     * @param Pool|TemplateRegistryInterface|null $deprecatedPoolOrTemplateRegistry
     * @param TemplateRegistryInterface|null      $deprecatedTemplateRegistry
     */
    public function __construct(
        $deprecatedNameOrEnvironment,
        $deprecatedEngineOrPool,
        $deprecatedPoolOrTemplateRegistry,
        $deprecatedTemplateRegistry
    ) {
        if ($deprecatedEngineOrPool instanceof Pool) {
            parent::__construct($deprecatedNameOrEnvironment);

            $this->pool = $deprecatedEngineOrPool;
            $this->templateRegistry = $deprecatedPoolOrTemplateRegistry ?: new TemplateRegistry();
        } else {
            parent::__construct($deprecatedNameOrEnvironment, $deprecatedEngineOrPool);

            $this->pool = $deprecatedPoolOrTemplateRegistry;
            $this->templateRegistry = $deprecatedTemplateRegistry ?: new TemplateRegistry();
        }

    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $dashboardGroups = $this->pool->getDashboardGroups();

        $settings = $blockContext->getSettings();

        $visibleGroups = [];
        foreach ($dashboardGroups as $name => $dashboardGroup) {
            if (!$settings['groups'] || \in_array($name, $settings['groups'], true)) {
                $visibleGroups[] = $dashboardGroup;
            }
        }

        return $this->renderPrivateResponse($this->templateRegistry->getTemplate('list_block'), [
            'block' => $blockContext->getBlock(),
            'settings' => $settings,
            'admin_pool' => $this->pool,
            'groups' => $visibleGroups,
        ], $response);
    }

    public function getName()
    {
        return 'Admin List';
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'groups' => false,
        ]);

        $resolver->setAllowedTypes('groups', ['bool', 'array']);
    }
}
