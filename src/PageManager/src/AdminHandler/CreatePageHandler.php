<?php

declare(strict_types=1);

namespace PageManager\AdminHandler;

use Axleus\Authorization\AdminResourceInterface;
use Axleus\Authorization\AuthorizedServiceInterface;
use Axleus\Authorization\AuthorizedServiceTrait;
use Axleus\Authorization\PrivilegeInterface;
use Axleus\Authorization\PrivilegeInterfaceTrait;
use Axleus\Authorization\ResourceInterfaceTrait;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Mezzio\Template\TemplateRendererInterface;

class CreatePageHandler implements AdminResourceInterface, AuthorizedServiceInterface, RequestHandlerInterface
{
    use AuthorizedServiceTrait;
    use PrivilegeInterfaceTrait;
    use ResourceInterfaceTrait;

    public const PRIVILEGE_ID = 'create';

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    private $responseFactory;

    public function __construct(
        TemplateRendererInterface $renderer,
        callable $responseFactory
    ) {
        $this->renderer = $renderer;
        $this->responseFactory = static fn(): ResponseInterface => $responseFactory();
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if ($this->isAllowed(request:$request)) {
            return new HtmlResponse($this->renderer->render(
                'page-manager::create-page',
                ['layout' => 'layout::admin'] // set the layout to admin
            ));
        }
        return ($this->responseFactory)()->withStatus(403);
    }

    public function getPrivilege(): ?string
    {
        return self::PRIVILEGE_ID;
    }
}
