<?php

declare(strict_types=1);

namespace App\AdminHandler;

use Mezzio\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class DashBoardHandlerFactory
{
    public function __invoke(ContainerInterface $container) : DashBoardHandler
    {
        return new DashBoardHandler(
            $container->get(TemplateRendererInterface::class),
            $container->get(ResponseInterface::class)
        );
    }
}
