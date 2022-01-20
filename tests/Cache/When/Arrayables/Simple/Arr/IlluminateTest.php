<?php

declare(strict_types=1);

namespace Tests\Cache\When\Arrayables\Simple\Arr;

use Tests\Cache\When\BaseTest;
use Tests\Fixtures\Simple\IlluminateArrayable;

class IlluminateTest extends BaseTest
{
    protected $value = [
        'foo' => 'Foo',
        'bar' => 'Bar',
    ];

    public function testGet()
    {
        $this->assertNull($this->cache()->get());

        $this->cache()->put(new IlluminateArrayable());

        $this->assertSame($this->value, $this->cache()->get());
    }

    public function testPut()
    {
        $this->assertSame($this->value, $this->cache()->put(new IlluminateArrayable()));

        $this->assertSame($this->value, $this->cache()->get());
    }

    public function testRemember()
    {
        $this->assertSame($this->value, $this->cache()->remember(new IlluminateArrayable()));

        $this->assertSame($this->value, $this->cache()->get());
    }

    public function testForget()
    {
        $this->assertNull($this->cache()->get());

        $this->cache()->put(new IlluminateArrayable());

        $this->cache()->forget();

        $this->assertNull($this->cache()->get());
    }

    public function testHas()
    {
        $this->assertFalse($this->cache()->has());

        $this->cache()->put(new IlluminateArrayable());

        $this->assertTrue($this->cache()->has());
    }

    public function testDoesntHave()
    {
        $this->assertTrue($this->cache()->doesntHave());

        $this->cache()->put(new IlluminateArrayable());

        $this->assertFalse($this->cache()->doesntHave());
    }
}
