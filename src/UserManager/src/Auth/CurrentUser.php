<?php

declare(strict_types=1);

namespace UserManager\Auth;

use Axleus\Authorization\AuthorizedServiceInterface;
use Axleus\Authorization\AuthorizedServiceTrait;
use Mezzio\Authentication\UserInterface;

/**
 * Default implementation of UserInterface.
 *
 * This implementation is modeled as immutable, to prevent propagation of
 * user state changes.
 *
 * We recommend that any details injected are serializable.
 */
final class CurrentUser implements AuthorizedServiceInterface, UserInterface
{
    use AuthorizedServiceTrait;

    private string $identity;

    /** @psalm-var array<int|string, string> */
    private $roles;

    /** @psalm-var array<string, mixed> */
    private $details;

    /**
     * @psalm-param array<int|string, string> $roles
     * @psalm-param array<string, mixed> $details
     */
    public function __construct(string $identity, array $roles = [], array $details = [])
    {
        $this->identity = $identity;
        $this->roles    = $roles;
        $this->details  = $details;
    }

    /**
     * @see AuthorizedServiceInterface
     * @return mixed
     */
    public function getOwnerId()
    {
        return $this->getDetail('id', null);
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    /**
     * @psalm-return array<int|string, string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @see AuthorizedServiceInterface
     * @return array|string|null
     */
    public function getRoleId(): array|string|null
    {
        if (isset($this->roleId) && in_array($this->roleId, $this->roles)) {
            return $this->roleId;
        }
        return $this->getRoles();
    }

    /**
     * @psalm-return array<string, mixed>
     */
    public function getDetails(): array
    {
        return $this->details;
    }

    /**
     * @param null|mixed $default Default value to return if no detail matching
     *     $name is discovered.
     * @return mixed
     */
    public function getDetail(string $name, $default = null)
    {
        return $this->details[$name] ?? $default;
    }
}
