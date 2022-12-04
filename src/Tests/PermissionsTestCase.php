<?php

declare(strict_types=1);

namespace MiBo\PX\Tests;

use MiBo\PX\Contracts\HasPermissionsInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class PermissionsTestCase
 *
 * The TestCase is prepared to test HasPermissionsInterface implementation.
 *
 * @package MiBo\PX\Tests
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
abstract class PermissionsTestCase extends TestCase
{
    /** @var \MiBo\PX\Tests\PermissionLoader */
    private static PermissionLoader $permissionLoader;

    /** @var \MiBo\PX\Tests\PermissionAssigner */
    private static PermissionAssigner $permissionAssigner;

    /**
     * Returns name of the target that is validated.
     *
     * @return string
     */
    abstract protected function getTargetName(): string;

    /**
     * Returns configured permissions in array.
     *
     * @phpcs:ignore
     * @phpstan-return array{groups: array<string, array{permissions: array<string>, inheritance: array<string>, default: bool}>, users: array{permissions: array<string>, groups: array<string>}}
     * @return array{groups: array<string, array<string, array<string>|bool>>}
     */
    abstract protected function getConfig(): array;

    /**
     *  Returns an array where the key "has" contains permissions that the target must have and the key
     * "hasNot" contains permissions that the target must not have.
     *
     * "has" and/or "hasNot" keys are not required to be present.
     *
     * @return array{has: array<string>, hasNot: array<string>}
     */
    abstract protected function getTargetVerifyData(): array;

    /**
     *  Returns the target that may have permissions assigned and is being validated that it contains
     * correct permissions.
     *
     * @return \MiBo\PX\Contracts\HasPermissionsInterface
     */
    abstract protected function getTarget(): HasPermissionsInterface;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->load();
    }

    /**
     * @internal
     *
     * @return void
     */
    protected function load(): void
    {
        static $loaded = false;

        if ($loaded === true) {
            return;
        }

        self::$permissionLoader   = new PermissionLoader($this->getConfig());
        self::$permissionAssigner = new PermissionAssigner(self::$permissionLoader);

        $loaded = true;
    }

    /**
     * @small
     *
     * @coversNothing
     *
     * @return void
     */
    public function testPermissions(): void
    {
        $this->verify($this->getTarget(), $this->getTargetVerifyData());
    }

    /**
     * Runs the assertion on the target that it has and has not the permissions based on the provided data.
     *
     * @param \MiBo\PX\Contracts\HasPermissionsInterface $target Target to process.
     * @param array{has: array<string>, hasNot: array<string>} $data Permissions split into whether they
     *          should be assigned or not.
     *
     * @return void
     */
    protected function verify(HasPermissionsInterface $target, array $data): void
    {
        if (!empty($data["has"])) {
            self::assertHasPermissions($target, $data["has"]);
        }

        if (!empty($data["hasNot"])) {
            self::assertHasNotPermissions($target, $data["hasNot"]);
        }
    }

    /**
     * Asserts that the target has all provided permissions.
     *
     * @param \MiBo\PX\Contracts\HasPermissionsInterface $target Target to process.
     * @param array<string> $permissions List of permissions to check.
     *
     * @return void
     */
    public static function assertHasPermissions(HasPermissionsInterface $target, array $permissions)
    {
        foreach ($permissions as $permission) {
            self::assertHasPermission($target, $permission);
        }
    }

    /**
     * Asserts that the target has none of the provided permissions.
     *
     * @param \MiBo\PX\Contracts\HasPermissionsInterface $target Target to process.
     * @param array<string> $permissions List of permissions to check.
     *
     * @return void
     */
    public static function assertHasNotPermissions(HasPermissionsInterface $target, array $permissions)
    {
        foreach ($permissions as $permission) {
            self::assertHasNotPermission($target, $permission);
        }
    }

    /**
     * Asserts that the target has the provided permission.
     *
     * @param \MiBo\PX\Contracts\HasPermissionsInterface $target Target to process.
     * @param string $permission Permissions to check.
     *
     * @return void
     */
    public static function assertHasPermission(HasPermissionsInterface $target, string $permission): void
    {
        self::assertTrue(
            $target->hasPermission($permission),
            "Failed asserting that target has permission $permission."
        );
    }

    /**
     * Asserts that the target has not the provided permission.
     *
     * @param \MiBo\PX\Contracts\HasPermissionsInterface $target Target to process.
     * @param string $permission Permissions to check.
     *
     * @return void
     */
    public static function assertHasNotPermission(HasPermissionsInterface $target, string $permission): void
    {
        self::assertTrue(
            $target->hasNotPermission($permission),
            "Failed asserting that target has not permission $permission."
        );
    }

    /**
     * @internal
     *
     * @return \MiBo\PX\Tests\PermissionAssigner
     */
    protected static function getPermissionAssigner(): PermissionAssigner
    {
        return self::$permissionAssigner;
    }

    /**
     * @internal
     *
     * @return \MiBo\PX\Tests\PermissionLoader
     */
    protected static function getPermissionLoader(): PermissionLoader
    {
        return self::$permissionLoader;
    }
}
