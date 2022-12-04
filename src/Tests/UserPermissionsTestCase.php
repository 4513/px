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
 * @author Michal Boris <michal.boris@gmail.com>
 */
abstract class UserPermissionsTestCase extends PermissionsTestCase
{
    /**
     * @inheritdoc
     */
    protected function getTarget(): HasPermissionsInterface
    {
        return $this->getPermissionAssigner()->getUser($this->getTargetName());
    }
}
