<?php

declare(strict_types=1);

namespace MiBo\PX\Contracts;

use Illuminate\Support\Collection;
use MiBo\PX\Permission;
use Stringable;

/**
 * Trait HasPermissionsTrait
 *
 * Implementation of the HasPermissionsInterface.
 *
 *  Use this trait in classes that contains permissions and no inheritance is allowed. If not sure, use
 * InheritsTrait.
 *
 *  To use this trait, call 'registerPermissions' when the list of the permissions is available, before
 * calling either 'hasPermission' or 'getPermissions'.
 *
 * @package MiBo\PX\Contracts
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
trait HasPermissionsTrait
{
    /** @var \Illuminate\Support\Collection<int, \MiBo\PX\Permission> */
    protected Collection $permissions;

    /** @var \Illuminate\Support\Collection<int, \MiBo\PX\Permission> */
    private Collection $allPermissions;

    /**
     * @phpcs:ignore
     * @param \Illuminate\Support\Collection<int, \MiBo\PX\Permission|\Stringable|string>|array<\MiBo\PX\Permission|\Stringable|string> $permissions
     *
     * @return static
     */
    protected function registerPermissions(Collection|array $permissions = []): static
    {
        if (!isset($this->permissions)) {
            $this->permissions = new Collection([]);
        }

        if ($permissions instanceof Collection) {
            $permissions = $permissions->toArray();
        }

        foreach ($permissions as $permission) {
            if (!$permission instanceof Permission) {
                $permission = Permission::create((string) $permission);
            }

            $this->permissions->add($permission);
        }

        unset($this->allPermissions);

        return $this;
    }

    /**
     * @inheritdoc
     */
    final public function hasPermission(Permission|Stringable|string $permission): bool
    {
        if (!is_string($permission)) {
            $permission = (string) $permission;
        }

        $has = $this->getPermissions()->search(
            function(Permission|Stringable|string $assignedPermission) use ($permission) {
                $assignedPermission = (string) $assignedPermission;
                $assignedPermission = preg_replace("/\./", "\\.", $assignedPermission);
                $assignedPermission = preg_replace("/\*$/", ".*", $assignedPermission);

                return preg_match("/^$assignedPermission$/", $permission) === 1;
            }
        );

        return $has !== false;
    }

    /**
     * @inheritdoc
     */
    final public function hasNotPermission(Permission|Stringable|string $permission): bool
    {
        return !$this->hasPermission($permission);
    }

    /**
     * @inheritdoc
     */
    public function getPermissions(): Collection
    {
        if (isset($this->allPermissions)) {
            return $this->allPermissions;
        }

        $permissions = new Collection($this->permissions);

        $this->allPermissions = $permissions->unique();

        return $this->allPermissions;
    }
}
