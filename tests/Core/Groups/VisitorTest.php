<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Groups;

use MiBo\PX\Tests\GroupPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class VisitorTest
 *
 * @package MiBo\PX\Tests\Core\Groups
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
class VisitorTest extends GroupPermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTargetName(): string
    {
        return "visitor";
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
