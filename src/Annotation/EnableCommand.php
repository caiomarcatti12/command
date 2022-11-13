<?php

namespace CaioMarcatti12\Command\Annotation;

use Attribute;
use CaioMarcatti12\Core\Modules\Modules;
use CaioMarcatti12\Core\Modules\ModulesEnum;
use CaioMarcatti12\Command\Adapter\RabbitMQAdapter;

#[Attribute(Attribute::TARGET_CLASS)]
class EnableCommand
{
    public function __construct()
    {
        Modules::enable(ModulesEnum::QUEUE_MANAGER);
    }
}
