<?php

declare(strict_types=1);

namespace PageManager\Storage;

use Axleus\Authorization\ProprietaryInterfaceTrait;
use Axleus\Authorization\ResourceInterfaceTrait;
use Axleus\Db;
use Axleus\Stdlib\Content\ContentInterface;

class PageEntity implements Db\EntityInterface, ContentInterface
{
    use Db\EntityTrait;
    use ProprietaryInterfaceTrait;

    public function __construct(
        protected array|int|string|null $id = null,
        protected ?string $title = null,
        protected ?string $description = null
    ) {
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): ContentInterface
    {
        $this->description = $description;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(array|int|string|null $id): ContentInterface
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): ContentInterface
    {
        $this->title = $title;
        return $this;
    }
}
