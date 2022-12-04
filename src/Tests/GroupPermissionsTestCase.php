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
 * @author Michal Boris <michal.boris@gmail.com>
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
