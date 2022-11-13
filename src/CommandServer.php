<?php

namespace CaioMarcatti12\Command;

use CaioMarcatti12\Cli\Interfaces\ArgvParserInterface;
use CaioMarcatti12\Command\Objects\Routes;
use CaioMarcatti12\Core\Factory\Annotation\Autowired;
use CaioMarcatti12\Core\Factory\InstanceFactory;
use CaioMarcatti12\Core\Factory\Invoke;
use CaioMarcatti12\Core\Modules\Modules;
use CaioMarcatti12\Core\Modules\ModulesEnum;
use CaioMarcatti12\Core\Shared\Interfaces\ServerRunInterface;
use CaioMarcatti12\Core\Validation\Assert;
use CaioMarcatti12\Data\Request\Objects\Body;
use CaioMarcatti12\Event\Interfaces\EventManagerInterface;
use CaioMarcatti12\Webserver\Exception\RouteNotFoundException;

class CommandServer implements ServerRunInterface
{
    #[Autowired]
    private ArgvParserInterface $argvParser;

    public function run($signature = ''): void
    {
        if(!Modules::isEnabled(ModulesEnum::COMMAND)) return;

        $route = Routes::getRoute($signature);

        if(Assert::isEmpty($route)) throw new RouteNotFoundException($signature);

        Body::set($this->argvParser->getAll());
        Invoke::new($route->getClass(), $route->getClassMethod());

        if (Modules::isEnabled(ModulesEnum::EVENT) && $route !== null) {
            /** @var EventManagerInterface $eventManager */
            $eventManager = InstanceFactory::createIfNotExists(EventManagerInterface::class);
            $eventManager->dispatch();
        }
    }
}