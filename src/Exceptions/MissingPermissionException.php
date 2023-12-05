<?php

declare(strict_types=1);

namespace MiBo\PX\Exceptions;

use Throwable;

/**
 * Interface MissingPermissionException
 *
 * The Exception SHOULD be thrown when the source does not have required Permission.
 *
 * @package MiBo\PX\Exceptions
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @since 1.1.0
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
interface MissingPermissionException extends Throwable
{
}
