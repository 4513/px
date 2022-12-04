<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Users;

use MiBo\PX\Tests\UserPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class GroupMemberTest
 *
 * @package MiBo\PX\Tests\Core\Users
 */
class GroupMemberTest extends UserPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "groupMember";
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
            ],
            "hasNot" => [
                "test.forum.comment.delete",
                "test.forum.comment.check",
            ],
        ];
    }
}
