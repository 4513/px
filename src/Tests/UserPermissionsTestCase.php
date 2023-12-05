<?php

declare(strict_types=1);

namespace MiBo\PX\Tests;

use MiBo\PX\Contracts\HasPermissionsInterface;

/**
 * Class UserPermissionsTestCase
 *
 * The TestCase covers a user's permissions.
 *
 * @package MiBo\PX\Tests
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
abstract class UserPermissionsTestCase extends PermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTarget(): HasPermissionsInterface
    {
        return self::getPermissionAssigner()->getUser($this->getTargetName());
    }
}
