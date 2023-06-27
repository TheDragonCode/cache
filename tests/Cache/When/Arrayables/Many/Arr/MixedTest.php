<?php

declare(strict_types=1);

namespace Tests\Cache\When\Arrayables\Many\Arr;

use Tests\Cache\When\Base;
use Tests\Fixtures\Many\MixedArrayable;

class MixedTest extends Base
{
    protected mixed $value = [
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

        $item = new MixedArrayable();

        $this->cache()->put($item);

        $this->assertSame(serialize($item), serialize($this->cache()->get()));
    }

    public function testPut()
    {
        $item = new MixedArrayable();

        $this->assertSame(serialize($item), serialize($this->cache()->put($item)));
        $this->assertSame(serialize($item), serialize($this->cache()->get()));
    }

    public function testRemember()
    {
        $item = new MixedArrayable();

        $this->assertSame(serialize($item), serialize($this->cache()->remember($item)));
        $this->assertSame(serialize($item), serialize($this->cache()->get()));
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

        $this->assertTrue($this->cache()->has());
    }

    public function testDoesntHave()
    {
        $this->assertTrue($this->cache()->doesntHave());

        $this->cache()->put(new MixedArrayable());

        $this->assertFalse($this->cache()->doesntHave());
    }
}
