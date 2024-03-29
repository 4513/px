<?php

declare(strict_types=1);

namespace MiBo\PX;

use Stringable;

/**
 * Class Permission
 *
 * @package MiBo\PX
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
class Permission implements Stringable
{
    private string $name;

    /** @var array<\MiBo\PX\Permission> */
    private static array $instances = [];

    /**
     * Checks that the current permission is exact as the provided one (comparison of their names).
     *
     * @param \MiBo\PX\Permission|\Stringable|string $permission Permission (name) to compare.
     *
     * @return bool True if both names are same, false otherwise.
     */
    final public function is(self|Stringable|string $permission): bool
    {
        return $this->toString() === (string) $permission;
    }

    /**
     * @param string $name Name of the Permission.
     */
    final protected function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * If the Permission with the same name has not been created before, creates one.
     *
     * Returns the Permission with provided name.
     *
     * @param string $permission Name of the Permission.
     *
     * @return \MiBo\PX\Permission Permission.
     */
    public static function create(string $permission): self
    {
        if (key_exists($permission, self::$instances)) {
            return self::$instances[$permission];
        }

        self::$instances[$permission] = new self($permission);

        return self::$instances[$permission];
    }

    /**
     * Returns name of the Permission.
     *
     * @return string Permission's name.
     */
    public function toString(): string
    {
        return $this->name;
    }

    /**
     * Returns name of the Permission.
     *
     * @return string Permission's name.
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
