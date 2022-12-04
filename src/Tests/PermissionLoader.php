<?php

declare(strict_types=1);

namespace MiBo\PX\Tests;

use Illuminate\Support\Collection;
use MiBo\PX\Permission;

/**
 * Class PermissionLoader
 *
 * @internal
 *
 * @package MiBo\PX\Tests
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
class PermissionLoader
{
    /** @var \Illuminate\Support\Collection */
    protected Collection $config;

    /**
     * @phpcs:ignore
     * @param array{groups: array<string, array{permissions: array<string>, inheritance: array<string>, default: bool}>, users: array<string, permissions: array<string>, groups: array<string>} $config
     */
    public function __construct(array $config)
    {
        $this->config = new Collection([]);

        $groups = [];
        $users  = [];

        foreach ($config["groups"] ?? [] as $groupName => $groupData) {
            $collectionGroup = [];

            foreach ($groupData["permissions"] ?? [] as $permission) {
                $collectionGroup["permissions"][] = Permission::create($permission);
            }

            foreach ($groupData["inheritance"] ?? [] as $inheritance) {
                $collectionGroup["inheritance"][] = $inheritance;
            }

            $collectionGroup["permissions"] = new Collection($collectionGroup["permissions"] ?? []);
            $collectionGroup["inheritance"] = new Collection($collectionGroup["inheritance"] ?? []);
            $collectionGroup["default"]     = (bool) ($groupData["default"] ?? false);

            $groups[$groupName] = new Collection($collectionGroup);
        }

        foreach ($config["users"] ?? [] as $userName => $userData) {
            $collectionUser = [];

            foreach ($userData["permissions"] ?? [] as $permission) {
                $collectionUser["permissions"][] = Permission::create($permission);
            }

            foreach ($userData["groups"] ?? [] as $group) {
                $collectionUser["groups"][] = $group;
            }

            $collectionUser["groups"]      = new Collection($collectionUser["groups"] ?? []);
            $collectionUser["permissions"] = new Collection($collectionUser["permissions"] ?? []);

            $users[$userName] = new Collection($collectionUser);
        }

        $this->config = new Collection(
            [
                "groups" => new Collection($groups),
                "users"  => new Collection($users),
            ]
        );
    }

    /**
     * @param string $name
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function getUser(string $name): ?Collection
    {
        return $this->getUsers()->get($name);
    }

    /**
     * @phpcs:ignore
     * @return \Illuminate\Support\Collection{permissions: \Illuminate\Support\Collection<string>, groups: \Illuminate\Support\Collection<string>, default: bool}|null
     */
    public function getUsers(): Collection
    {
        return $this->getConfig()->get("users", new Collection([]));
    }

    /**
     * @param string $groupName
     *
     * @phpcs:ignore
     * @return \Illuminate\Support\Collection{permissions: \Illuminate\Support\Collection<string>, inheritance: \Illuminate\Support\Collection<string>, default: bool}|null
     */
    public function getGroup(string $groupName): ?Collection
    {
        return $this->getGroups()->get($groupName);
    }

    /**
     * @phpcs:ignore
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection{permissions: \Illuminate\Support\Collection<string>, inheritance: \Illuminate\Support\Collection<string>, default: bool}|null>
     */
    public function getGroups(): Collection
    {
        return $this->getConfig()->get("groups", new Collection([]));
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function getConfig(): Collection
    {
        return $this->config;
    }
}
