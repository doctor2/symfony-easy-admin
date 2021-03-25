<?php

namespace App;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $this->registerExtension($container);
    }

    protected function registerExtension(ContainerBuilder $container): void
    {
        $extensions = require dirname(__DIR__) . '/config/extensions.php';

        foreach ($extensions as $extension) {
            $container->registerExtension($extension);
        }
    }
}
