<?php

declare(strict_types=1);

namespace PageManager\Handler;

use Axleus\Boards;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\JsonResponse;
use League\Tactician\CommandBus;
use Mezzio\Template\TemplateRendererInterface;
use PageManager\Storage;
use PageManager\Storage\PageEntity;
use PageManager\Storage\PageRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class PageHandler implements RequestHandlerInterface
{
    public function __construct(
        private ?TemplateRendererInterface $template = null,
        private ?CommandBus $commandBus = null,
        private ?PageRepository $repo = null
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        //$page = new PageEntity(null, 'Test Page', 'This is testing the query profiler');
        //$this->commandBus->handle(new Storage\SavePageCommand($page));

        //$page2 = new PageEntity(null, 'Secondary Page', 'Just adding another query to test the panel');
        //$this->commandBus->handle(new Storage\SavePageCommand($page2));

        $entities = ($this->repo?->findAllByTitle('Test Page'));

        // debug message usage
        // $debug = $request->getAttribute(DebugBar::class);
        // $debug['messages']->addMessage(
        //     ($request->getAttribute('translator'))->translate('forbidden_403')
        // );

        if ($this->template === null) {
            return new JsonResponse([]);
        }

        return new HtmlResponse($this->template->render('page-manager::page'));
    }
}
