<?php

namespace Tests\Unit\Helpers;

use App\Helpers\FakeTime;
use Tests\TestCase;

class FakeTimeTest extends TestCase
{
    public function setUp(): void
    {
        if (file_exists(FakeTime::getFilePath())) {
            unlink(FakeTime::getFilePath());
        }
    }

    /**
     * @test
     */
    public function set_and_get_time()
    {
        $faketime = FakeTime::getInstance();
        $testTimestamp = time();
        $faketime->set($testTimestamp);

        $this->assertEquals($testTimestamp, $faketime->get());
    }

    /**
     * @test
     */
    public function inrement_time()
    {
        $faketime = FakeTime::getInstance();

        $testTimestamp = time();
        $faketime->set($testTimestamp);
        $faketime->increment(10);

        $this->assertEquals($testTimestamp + 10, $faketime->get());
    }
}
