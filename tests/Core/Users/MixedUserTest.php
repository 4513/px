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
 * Class MixedUserTest
 *
 * @package MiBo\PX\Tests\Core\Users
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 */
#[CoversClass(HasPermissionsTrait::class)]
#[CoversClass(InheritsTrait::class)]
#[CoversClass(Permission::class)]
class MixedUserTest extends UserPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "mixedUser";
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
            "has"    => [
                "test.forum.view",
                "test.security.authentication.logout.self",
                "test.forum.comment.delete",
            ],
            "hasNot" => ["test.forum.comment.check"],
        ];
    }
}
