<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Users;

use MiBo\PX\Tests\UserPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class NoPermissionUserTest
 *
 * @package MiBo\PX\Tests\Core\Users
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
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
