<?php

namespace availability_releasecode\tests;

use availability_releasecode\condition;
use core_availability\mock_info;

require_once(__DIR__.'/../../../tests/fixtures/mock_info.php');

class condition_test extends \advanced_testcase {

    public function setUp() {
        $this->resetAfterTest();

        $data = include(__DIR__.'/fixtures/codes.php');
        $this->loadDataSet($this->createArrayDataSet($data));
    }

    public function test_save() {
        $expected  = (object) array('type' => 'releasecode', 'rc' => '123');
        $condition = new condition((object) array('rc' => '123'));
        $this->assertEquals($expected, $condition->save());
    }

    public function test_is_available() {
        // Fudge course so it matches our fixtures.
        $course = get_site();
        $course->id = 2;

        $info = new mock_info($course);
        $condition = new condition((object) array('rc' => 'ABC'));

        $this->assertTrue($condition->is_available(false, $info, false, 3));
        $this->assertFalse($condition->is_available(true, $info, false, 3));
        $this->assertFalse($condition->is_available(false, $info, false, 4));
    }
}