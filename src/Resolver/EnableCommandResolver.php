<?php

namespace CaioMarcatti12\Command\Resolver;

use CaioMarcatti12\Command\Annotation\EnableCommand;
use CaioMarcatti12\Core\Bean\Annotation\AnnotationResolver;
use CaioMarcatti12\Core\Bean\Interfaces\ClassResolverInterface;
use ReflectionClass;

#[AnnotationResolver(EnableCommand::class)]
class EnableCommandResolver implements ClassResolverInterface
{
    public function handler(object &$instance): void
    {
        $reflectionClass = new ReflectionClass($instance);

        $attributes = $reflectionClass->getAttributes(EnableCommand::class);

        /** @var EnableCommand $attribute */
        $attribute = ($attributes[0]->newInstance());
    }
}