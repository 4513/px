<?php

declare(strict_types=1);

namespace MiBo\PX\Tests\Core;

use MiBo\PX\Permission;
use PHPUnit\Framework\TestCase;
use Stringable;

/**
 * Class PermissionTest
 *
 * @package MiBo\PX\Tests\Core
 *
 * @author Michal Boris <michal.boris27@gmail.com>
 *
 * @no-named-arguments Parameter names are not covered by the backward compatibility promise.
 */
final class PermissionTest extends TestCase
{
    /**
     * @small
     *
     * @covers \MiBo\PX\Permission::is
     *
     * @param bool $expected
     * @param string $first
     * @param string|\Stringable|\MiBo\PX\Permission $second
     *
     * @return void
     *
     * @dataProvider getData
     */
    public function testPermissionIs(bool $expected, string $first, string|Stringable|Permission $second): void
    {
        self::assertSame($expected, Permission::create($first)->is($second));
    }

    /**
     * @return array<int, array{
     *     0: bool,
     *     1: string,
     *     2: string|\Stringable|\MiBo\PX\Permission
     * }>
     */
    public static function getData(): array
    {
        return [
            [
                true,
                'foo',
                'foo',
            ],
            [
                true,
                'foo',
                Permission::create('foo'),
            ],
            [
                true,
                'foo',
                new class implements Stringable {
                    public function __toString(): string
                    {
                        return 'foo';
                    }
                },
            ],
            [
                false,
                'foo',
                'bar',
            ],
            [
                false,
                'foo',
                Permission::create('bar'),
            ],
            [
                false,
                'foo',
                new class implements Stringable {
                    public function __toString(): string
                    {
                        return 'bar';
                    }
                },
            ],
        ];
    }
}
