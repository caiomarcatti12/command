<?php

namespace CaioMarcatti12\Command;

use CaioMarcatti12\Command\Annotation\Command;
use CaioMarcatti12\Command\Objects\Route;
use CaioMarcatti12\Command\Objects\Routes;
use CaioMarcatti12\Core\ExtractPhpNamespace;
use CaioMarcatti12\Core\Launcher\Annotation\Launcher;
use CaioMarcatti12\Core\Launcher\Enum\LauncherPriorityEnum;
use CaioMarcatti12\Core\Launcher\Interfaces\LauncherInterface;
use CaioMarcatti12\Core\Validation\Assert;

#[Launcher(LauncherPriorityEnum::BEFORE_LOAD_APPLICATION)]
class RouterLoader implements LauncherInterface
{
    public function handler(): void
    {
        $filesApplication = ExtractPhpNamespace::getFilesApplication();

        $this->parseFiles($filesApplication);
    }

    private  function parseFiles(array $files): void{
        foreach($files as $file){
            $reflectionClass = new \ReflectionClass($file);

            $reflectionAttributes = $reflectionClass->getAttributes(Command::class);

            if(Assert::isNotEmpty($reflectionAttributes)) {
                /** @var \ReflectionAttribute $attribute */
                $attribute = array_shift($reflectionAttributes);

                /** @var Command $instanceAttributeClass */
                $instanceAttributeClass = $attribute->newInstance();

                $signature = $instanceAttributeClass->getSignature();

                $this->addRoute($signature, $reflectionClass->getName(),'handler');
            }
        }
    }

    private function addRoute(string $uri, string $file, $method): void {
        $route = new Route($uri, $file, $method);
        Routes::add($route);
    }
}