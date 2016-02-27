<?php

namespace ganglio\tests;

use \ganglio\Memoizer;

class MemoizerTest extends \PHPUnit_Framework_TestCase
{

    protected $func;

    protected function setUp()
    {

        $this->func = function ($a) {
            return $a * mt_rand();
        };

        $this->slow_func = function ($a) {
            sleep(5);
            return $a * mt_rand();
        };
    }

    protected function tearDown()
    {
        $this->func = null;
    }

    /**
     * @expectedException InvalidArgumentException
     * excectedExceptionCode 1
     */
    public function testConstructionArgumentNotCallable()
    {
        new Memoizer(33);
    }

    public function testReturnsCallable()
    {
        $this->assertTrue(
            is_callable(new Memoizer($this->func))
        );
    }

    public function testReturnSame()
    {
        $me = new Memoizer($this->func);

        $this->assertEquals(
            $me(1),
            $me(1)
        );
    }

    public function testUseCache()
    {
        $me = new Memoizer($this->slow_func);

        $ts = time();
        $me(1);
        $dt_first_run = time() - $ts;

        $ts = time();
        $me(1);
        $dt_second_run = time()- $ts;

        $this->assertEquals(
            $dt_first_run,
            5
        );
        $this->assertEquals(
            $dt_second_run,
            0
        );
    }

}
