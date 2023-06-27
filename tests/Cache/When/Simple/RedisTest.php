<?php

declare(strict_types=1);

namespace Tests\Cache\When\Simple;

use Illuminate\Support\Facades\Auth;
use Tests\Cache\When\Base;
use Tests\Fixtures\Models\User;

class RedisTest extends Base
{
    protected string $cache = 'redis';

    public function testGet()
    {
        $this->assertNull($this->cache()->get());

        $this->cache()->put($this->value);

        $this->assertSame($this->value, $this->cache()->get());
        $this->assertSame($this->value, $this->cache(['qwerty', 'cache'])->get());

        $this->assertNull($this->cache(['qwerty'])->get());
        $this->assertNull($this->cache(['cache'])->get());
    }

    public function testPut()
    {
        $this->assertSame($this->value, $this->cache()->put($this->value));

        $this->assertSame($this->value, $this->cache()->get());
        $this->assertSame($this->value, $this->cache(['qwerty', 'cache'])->get());

        $this->assertNull($this->cache(['qwerty'])->get());
        $this->assertNull($this->cache(['cache'])->get());
    }

    public function testRemember()
    {
        $this->assertSame($this->value, $this->cache()->remember($this->value));

        $this->assertSame($this->value, $this->cache()->get());
        $this->assertSame($this->value, $this->cache(['qwerty', 'cache'])->get());

        $this->assertNull($this->cache(['qwerty'])->get());
        $this->assertNull($this->cache(['cache'])->get());
    }

    public function testForget()
    {
        $this->assertNull($this->cache()->get());

        $this->cache()->put($this->value);

        $this->cache()->forget();

        $this->assertNull($this->cache()->get());
        $this->assertNull($this->cache(['qwerty', 'cache'])->get());
        $this->assertNull($this->cache(['qwerty'])->get());
        $this->assertNull($this->cache(['cache'])->get());
    }

    public function testHas()
    {
        $this->assertFalse($this->cache()->has());

        $this->cache()->put($this->value);

        $this->assertTrue($this->cache()->has());
        $this->assertTrue($this->cache(['qwerty', 'cache'])->has());

        $this->assertFalse($this->cache(['qwerty'])->has());
        $this->assertFalse($this->cache(['cache'])->has());
    }

    public function testDoesntHave()
    {
        $this->assertTrue($this->cache()->doesntHave());

        $this->cache()->put($this->value);

        $this->assertFalse($this->cache()->doesntHave());
        $this->assertFalse($this->cache(['qwerty', 'cache'])->doesntHave());

        $this->assertTrue($this->cache(['qwerty'])->doesntHave());
        $this->assertTrue($this->cache(['cache'])->doesntHave());
    }

    public function testWithAuth()
    {
        $user = new User([
            'id'   => 123,
            'name' => 'John Doe',
        ]);

        Auth::setUser($user);

        $this->assertTrue(Auth::check());

        $this->assertTrue($this->cache()->doesntHave());
        $this->assertTrue($this->cache()->withAuth()->doesntHave());

        $this->cache()->put($this->value);
        $this->cache()->withAuth()->put($this->value_second);

        $this->assertFalse($this->cache()->doesntHave());
        $this->assertTrue($this->cache()->withAuth()->has());

        $key = [User::class, $this->user_id, 'Foo', 'Bar', 'Baz'];

        $this->assertSame($this->value_second, $this->cache()->withAuth()->get());
        $this->assertSame($this->value_second, $this->cache([], $key)->get());
    }
}
