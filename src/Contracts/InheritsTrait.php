<?php

declare(strict_types=1);

namespace MiBo\PX\Contracts;

use Illuminate\Support\Collection;

/**
 * Trait InheritsTrait
 *
 *  The wrapper of the HasPermissionsTrait, however provides possibility to inherit permissions from other
 * permission-able objects, such as groups.
 *
 *  To use this trait, call 'registerPermissions' when the list of the permissions is available, before
 * calling either 'hasPermission' or 'getPermissions'. To inherit permissions from other object, set the
 * 'inheritances' Collection before calling 'hasPermission' or 'getPermissions'.
 *
 * @package MiBo\PX\Contracts
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
trait InheritsTrait
{
    use HasPermissionsTrait {
        HasPermissionsTrait::getPermissions as contractGetPermissions;
    }

    /** @var \Illuminate\Support\Collection<int, \MiBo\PX\Contracts\HasPermissionsInterface> */
    protected Collection $inheritances;

    /**
     * @inheritdoc
     */
    public function getPermissions(): Collection
    {
        if (!empty($this->allPermissions)) {
            return $this->allPermissions;
        }

        $permissions = $this->contractGetPermissions();

        if (!empty($this->inheritances)) {
            $this->inheritances->each(function(HasPermissionsInterface $parent) use (&$permissions) {
                $permissions = $permissions->merge($parent->getPermissions());
            });
        }

        $this->allPermissions = $permissions->unique();

        return $this->allPermissions;
    }
}
