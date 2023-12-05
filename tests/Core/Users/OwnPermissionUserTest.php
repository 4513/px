<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Users;

use MiBo\PX\Tests\UserPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class OwnPermissionUserTest
 *
 * @package MiBo\PX\Tests\Core\Users
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 */
class OwnPermissionUserTest extends UserPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "ownPermissionUser";
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
            "has"    => ["test.security.permissions.assign"],
            "hasNot" => [
                "test.forum.comment.delete",
                "test.forum.comment.check",
            ],
        ];
    }
}
