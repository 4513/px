<?php

namespace MiBo\PX\Exceptions;

use Throwable;

/**
 * Interface MissingPermissionException
 *
 * The Exception SHOULD be thrown when the source does not have required Permission.
 *
 * @package MiBo\PX\Exceptions
 *
 * @author Michal Boris <michal.boris@gmail.com>
 */
interface MissingPermissionException extends Throwable
{
}
