<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Groups;

use MiBo\PX\Contracts\HasPermissionsTrait;
use MiBo\PX\Contracts\InheritsTrait;
use MiBo\PX\Permission;
use MiBo\PX\Tests\GroupPermissionsTestCase;
use Nette\Neon\Neon;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Class RootTest
 *
 * @package MiBo\PX\Tests\Core\Groups
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 */
#[CoversClass(HasPermissionsTrait::class)]
#[CoversClass(InheritsTrait::class)]
#[CoversClass(Permission::class)]
final class RootTest extends GroupPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "root";
    }

    /**
     * @inheritdoc
     *
     * @throws \Nette\Neon\Exception
     */
    protected function getConfig(): array
    {
        /** @phpstan-ignore-next-line Returns mixed */
        return Neon::decodeFile(__DIR__ . "/../permissions.yaml");
    }

    /**
     * @inheritdoc
     */
    protected function getTargetVerifyData(): array
    {
        return [
            "has"    => ["test.security.authentication.login.self"],
            "hasNot" => [],
        ];
    }
}
