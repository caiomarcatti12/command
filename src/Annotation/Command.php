<?php

namespace CaioMarcatti12\Command\Annotation;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Command
{
    private string $signature;

    public function __construct(string $signature)
    {
        $this->signature = $signature;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}