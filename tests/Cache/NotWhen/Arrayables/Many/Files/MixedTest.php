<?php

declare(strict_types=1);

namespace Tests\Cache\NotWhen\Arrayables\Many\Files;

use Tests\Cache\NotWhen\BaseTest;
use Tests\Fixtures\Many\MixedArrayable;

class MixedTest extends BaseTest
{
    protected $cache = 'file';

    protected $value = [
        'foo' => 'Foo',
        'bar' => 'Bar',
        'baz' => [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ],
        'baq' => [
            'foo' => 'Foo',
            'bar' => 'Bar',
        ],
    ];

    public function testGet()
    {
        $this->assertNull($this->cache()->get());

        $this->cache()->put(new MixedArrayable());

        $this->assertNull($this->cache()->get());
    }

    public function testPut()
    {
        $this->assertSame($this->value, $this->cache()->put(new MixedArrayable()));

        $this->assertNull($this->cache()->get());
    }

    public function testRemember()
    {
        $this->assertSame($this->value, $this->cache()->remember(new MixedArrayable()));

        $this->assertNull($this->cache()->get());
    }

    public function testForget()
    {
        $this->assertNull($this->cache()->get());

        $this->cache()->put(new MixedArrayable());

        $this->cache()->forget();

        $this->assertNull($this->cache()->get());
    }

    public function testHas()
    {
        $this->assertFalse($this->cache()->has());

        $this->cache()->put(new MixedArrayable());

        $this->assertFalse($this->cache()->has());
    }

    public function testDoesntHave()
    {
        $this->assertTrue($this->cache()->doesntHave());

        $this->cache()->put(new MixedArrayable());

        $this->assertTrue($this->cache()->doesntHave());
    }
}
