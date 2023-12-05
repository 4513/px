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
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
class PermissionLoader
{
    /** @var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string, mixed>> */
    protected Collection $config;

    /**
     * @param array{
     *     groups?: array<string, array{
     *         permissions?: array<string>,
     *         inheritance?: array<string>,
     *         default?: bool
     *     }>,
     *     users?: array<string>,
     *     permissions?: array<string>,
     *     groups?: array<string>
     * } $config
     */
    public function __construct(array $config)
    {
        $this->config = new Collection(
            [
                "groups" => new Collection($this->composeGroupConfig($config['groups'] ?? [])),
                "users"  => new Collection($this->composeUserConfig($config['users'] ?? [])),
            ]
        );
    }

    /**
     * @param string $name
     *
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool>|null
     */
    public function getUser(string $name): ?Collection
    {
        /** @phpstan-var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool>|null */
        return $this->getUsers()->get($name);
    }

    /**
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool>
     */
    public function getUsers(): Collection
    {
        /** @phpstan-var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool> */
        return $this->getConfig()->get("users", new Collection([]));
    }

    /**
     * @param string $groupName
     *
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool>|null
     */
    public function getGroup(string $groupName): ?Collection
    {
        /** @phpstan-var \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool>|null */
        return $this->getGroups()->get($groupName);
    }

    /**
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string>|bool>
     */
    public function getGroups(): Collection
    {
        return $this->getConfig()->get("groups", new Collection([]));
    }

    /**
     * @return \Illuminate\Support\Collection<string, \Illuminate\Support\Collection<string, mixed>>
     */
    protected function getConfig(): Collection
    {
        return $this->config;
    }

    /**
     * @param array<string, array{
     *     permissions?: array<string>,
     *     inheritance?: array<string>,
     *     default?: bool
     * }> $config
     *
     * @return array<\Illuminate\Support\Collection<string, bool|\Illuminate\Support\Collection<int, string>>>
     */
    // @phpcs:ignore SlevomatCodingStandard.Complexity.Cognitive.ComplexityTooHigh
    private function composeGroupConfig(array $config): array
    {
        if (count($config) === 0) {
            return [];
        }

        foreach ($config as $groupName => $groupData) {
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

        return $groups;
    }

    /**
     * @param array<string, array{
     *     permissions?: array<string>,
     *     groups?: array<string>
     * }> $config
     *
     * @return array<\Illuminate\Support\Collection<string, bool|\Illuminate\Support\Collection<int, string>>>
     */
    // @phpcs:ignore SlevomatCodingStandard.Complexity.Cognitive.ComplexityTooHigh
    private function composeUserConfig(array $config): array
    {
        if (count($config) === 0) {
            return [];
        }

        $users = [];

        foreach ($config as $userName => $userData) {
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

        return $users;
    }
}
