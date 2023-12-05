<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Users;

use MiBo\PX\Tests\UserPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class MixedUserTest
 *
 * @package MiBo\PX\Tests\Core\Users
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 */
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
