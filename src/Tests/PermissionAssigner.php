<?php

declare(strict_types=1);

namespace MiBo\PX\Tests;

use CompileError;
use Illuminate\Support\Collection;
use MiBo\PX\Contracts\HasPermissionsInterface;
use MiBo\PX\Contracts\InheritsTrait;

/**
 * Class PermissionAssigner
 *
 * The Assigner creates and returns a HasPermissionsInterface implementation based on the Loader.
 *
 * @internal
 *
 * @package MiBo\PX\Tests
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
class PermissionAssigner
{
    protected PermissionLoader $loader;

    public function __construct(PermissionLoader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Returns the class of provided name.
     *
     * @param string $name Group name.
     *
     * @return \MiBo\PX\Contracts\HasPermissionsInterface Found group.
     */
    public function getGroup(string $name): HasPermissionsInterface
    {
        $group = $this->getLoader()->getGroup($name);

        if ($group === null) {
            throw new CompileError("Failed to load group $name");
        }

        $groups = [];

        foreach ($group->get("inheritance", []) as $inheritance) {
            $groups[] = $this->getGroup($inheritance);
        }

        /** @var \Illuminate\Support\Collection<int, \MiBo\PX\Permission> $permissions */
        $permissions = $group->get("permissions", new Collection([]));

        return new class ($groups, $permissions) implements HasPermissionsInterface {
            use InheritsTrait;

            /**
             * @param array<\MiBo\PX\Contracts\HasPermissionsInterface> $groups
             * @phpcs:ignore
             * @param \Illuminate\Support\Collection<int, \MiBo\PX\Permission|\Stringable|string>|array<\MiBo\PX\Permission|\Stringable|string> $permissions
             */
            public function __construct(array $groups, Collection|array $permissions)
            {
                $this->registerPermissions($permissions);
                $this->inheritances = new Collection($groups);
            }
        };
    }

    /**
     *  Returns the user of provided name. If the user does not exist, creates one and assigns to it the
     * default group.
     *
     * @param string $name User name.
     *
     * @return \MiBo\PX\Contracts\HasPermissionsInterface Found user.
     */
    public function getUser(string $name): HasPermissionsInterface
    {
        $user = $this->getLoader()->getUser($name);

        if ($user !== null) {
            /** @var \Illuminate\Support\Collection $permissions */
            $permissions    = $user->get("permissions", new Collection([]));
            $assignedGroups = $user->get("groups", new Collection([]));
        } else {
            $permissions    = new Collection([]);
            $assignedGroups = $this->getLoader()->getGroups()->search(
                static fn (Collection $collection): bool => $collection->get("default", false) === true
            );

            $assignedGroups = new Collection($assignedGroups === false ? [] : $assignedGroups);
        }

        $groups = [];

        foreach ($assignedGroups->values() as $groupName) {
            $groups[] = $this->getGroup($groupName);
        }

        // @phpcs:disable:SlevomatCodingStandard.Namespaces.FullyQualifiedClassNameInAnnotation.NonFullyQualifiedClassName
        // @phpcs:disable SlevomatCodingStandard.TypeHints.DisallowArrayTypeHintSyntax.DisallowedArrayTypeHintSyntax

        return new class ($groups, $permissions) implements HasPermissionsInterface {
            use InheritsTrait;

            /**
             * @param HasPermissionsInterface[] $groups
             * @phpcs:ignore SlevomatCodingStandard.Files.LineLength.LineTooLong
             * @param \Illuminate\Support\Collection<int, \MiBo\PX\Permission|\Stringable|string>|array<\MiBo\PX\Permission|\Stringable|string> $permissions
             */
            public function __construct(array $groups, Collection|array $permissions)
            {
                $this->registerPermissions($permissions);
                $this->inheritances = new Collection($groups);
            }
        };

        // @phpcs:enable:SlevomatCodingStandard.Namespaces.FullyQualifiedClassNameInAnnotation.NonFullyQualifiedClassName
        // @phpcs:enable SlevomatCodingStandard.TypeHints.DisallowArrayTypeHintSyntax.DisallowedArrayTypeHintSyntax
    }

    protected function getLoader(): PermissionLoader
    {
        return $this->loader;
    }
}
