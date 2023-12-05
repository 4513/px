<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Groups;

use MiBo\PX\Tests\GroupPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class UserTest
 *
 * @package MiBo\PX\Tests\Core\Groups
 */
final class UserTest extends GroupPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "user";
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
