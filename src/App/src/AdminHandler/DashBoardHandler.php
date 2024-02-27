<?php

declare(strict_types=1);

namespace App\AdminHandler;

use Axleus\Authorization\AuthorizedServiceInterface;
use Axleus\Authorization\AuthorizedServiceTrait;
use Axleus\Authorization\AdminResourceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Authentication\UserInterface;
use Mezzio\Template\TemplateRendererInterface;

class DashBoardHandler implements AdminResourceInterface, AuthorizedServiceInterface, RequestHandlerInterface
{
    use AuthorizedServiceTrait;

    public const PRIVILEGE_ID = 'dashboard';
    private $responseFactory;
    private $privilegeId = 'dashboard';

    public function __construct(
        private TemplateRendererInterface $renderer,
        callable $responseFactory
    ) {
        // Ensures type safety of the composed factory
        $this->responseFactory = static fn(): ResponseInterface => $responseFactory();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if (
            $this->isAllowed($request->getAttribute(UserInterface::class))) {
            return new HtmlResponse($this->renderer->render(
                'app::dash-board',
                ['layout' => 'layout::admin'] // parameters to pass to template
            ));
        }
        return ($this->responseFactory)()->withStatus(403);
    }
}
