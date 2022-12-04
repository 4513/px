<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core\Groups;

use MiBo\PX\Tests\GroupPermissionsTestCase;
use Nette\Neon\Neon;

/**
 * Class RootTest
 *
 * @package MiBo\PX\Tests\Core\Groups
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
class RootTest extends GroupPermissionsTestCase
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
