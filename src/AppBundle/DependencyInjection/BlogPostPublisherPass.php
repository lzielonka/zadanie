<?php

namespace AppBundle\DependencyInjection;

use AppBundle\Services\BlogPost\BlogPostPublisher;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class BlogPostPublisherPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(BlogPostPublisher::class)) {
            return;
        }

        $definition = $container->findDefinition(BlogPostPublisher::class);
        $taggedServices = $container->findTaggedServiceIds('app.publisher');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addPublisher', [new Reference($id)]);
        }
    }
}
