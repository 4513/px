<?php

declare(strict_types=1);

namespace MiBo\PX\Tests;

use MiBo\PX\Contracts\HasPermissionsInterface;

/**
 * Class GroupPermissionsTestCase
 *
 * The TestCase covers a group's permissions.
 *
 * @package MiBo\PX\Tests
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
abstract class GroupPermissionsTestCase extends PermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTarget(): HasPermissionsInterface
    {
        return self::getPermissionAssigner()->getGroup($this->getTargetName());
    }
}
