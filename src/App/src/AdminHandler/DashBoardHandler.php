<?php

declare(strict_types=1);

namespace App\AdminHandler;

use Axleus\Authorization\AuthorizedServiceInterface;
use Axleus\Authorization\AuthorizedServiceTrait;
use Axleus\Authorization\AdminResourceInterface;
use Axleus\Authorization\PrivilegeInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class DashBoardHandler implements AdminResourceInterface, AuthorizedServiceInterface, RequestHandlerInterface
{
    use AuthorizedServiceTrait;

    private $responseFactory;

    public function __construct(
        private TemplateRendererInterface $renderer,
        callable $responseFactory
    ) {
        // Ensures type safety of the composed factory
        $this->responseFactory = static fn(): ResponseInterface => $responseFactory();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if ($this->isAllowed(request: $request)) {
            return new HtmlResponse($this->renderer->render(
                'app::dash-board',
                ['layout' => 'layout::admin'] // parameters to pass to template
            ));
        }
        return ($this->responseFactory)()->withStatus(403);
    }

    public function getPrivilege(): string
    {
        return 'dashboard';
    }
}
