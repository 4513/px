<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Users;

use MiBo\PX\Tests\UserPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class DefaultUserTest
 *
 * @package MiBo\PX\Tests\Core\Users
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
class DefaultUserTest extends UserPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "aRandomStringToCheckThatIsNotThereForSure.JustInCase&%";
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
                "test.security.authentication.login.self",
                "test.security.authentication.register.self",
            ],
            "hasNot" => [
                "test.forum.comment.delete",
                "test.forum.comment.check",
                "test.forum.comment.add",
            ],
        ];
    }
}
