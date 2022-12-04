<?php

declare(strict_types=1);

namespace MiBo\PX\Contracts;

use Illuminate\Support\Collection;
use MiBo\PX\Permission;
use Stringable;

/**
 * Interface HasPermissionsInterface
 *
 * The Interface provides two methods to verify that the implemented class contains all required permissions.
 *
 *  One should prefer 'hasPermission' method over the 'getPermissions'. Note, that the implementation should
 * rather check that a user has a permission to do something than verifying that someone is forbidden to do
 * so - everything is forbidden by default, one must get a permission for allowed actions.
 *
 * @package MiBo\PX\Contracts
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
interface HasPermissionsInterface
{
    /**
     * Checks that the entity has the permission.
     *
     * @param \MiBo\PX\Permission|\Stringable|string $permission Permission to check.
     *
     * @return bool True if the entity has the permission, false otherwise.
     */
    public function hasPermission(Permission|Stringable|string $permission): bool;

    /**
     * Checks that the entity has not the permission.
     *
     * @param \MiBo\PX\Permission|\Stringable|string $permission Permission to check.
     *
     * @return bool True if the entity does not have the permission, false otherwise.
     */
    public function hasNotPermission(Permission|Stringable|string $permission): bool;

    /**
     * Returns all permissions the entity contains, including inherited ones.
     *
     * @return \Illuminate\Support\Collection<int, \MiBo\PX\Permission> All permissions.
     */
    public function getPermissions(): Collection;
}
