<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Users;

use MiBo\PX\Contracts\HasPermissionsTrait;
use MiBo\PX\Contracts\InheritsTrait;
use MiBo\PX\Permission;
use MiBo\PX\Tests\UserPermissionsTestCase;
use Nette\Neon\Neon;
use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Class NoPermissionUserTest
 *
 * @package MiBo\PX\Tests\Core\Users
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 */
#[CoversClass(HasPermissionsTrait::class)]
#[CoversClass(InheritsTrait::class)]
#[CoversClass(Permission::class)]
class NoPermissionUserTest extends UserPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "noPermissionUser";
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
            "has"    => [],
            "hasNot" => [
                "test.forum.comment.delete",
                "test.forum.comment.check",
                "test.forum.comment.add",
            ],
        ];
    }
}
