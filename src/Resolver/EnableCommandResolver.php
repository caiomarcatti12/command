<?php

namespace CaioMarcatti12\Command\Resolver;

use CaioMarcatti12\Command\Annotation\EnableCommand;
use CaioMarcatti12\Core\Bean\Annotation\AnnotationResolver;
use CaioMarcatti12\Core\Bean\Interfaces\ClassResolverInterface;

#[AnnotationResolver(EnableCommand::class)]
class EnableCommandResolver implements ClassResolverInterface
{
    public function handler(object &$instance): void
    {
        //Not have implements
    }
}