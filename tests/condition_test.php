<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace availability_releasecode\tests;

use availability_releasecode\condition;
use core_availability\mock_info;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/../../../tests/fixtures/mock_info.php');

class condition_test extends \advanced_testcase {

    public function setUp(): void {
        $this->resetAfterTest();

        $data = include(__DIR__.'/fixtures/codes.php');
        $this->dataset_from_array($data)->to_database();
    }

    public function test_save() {
        $expected  = (object) ['type' => 'releasecode', 'rc' => '123'];
        $condition = new condition((object) ['rc' => '123']);
        $this->assertEquals($expected, $condition->save());
    }

    public function test_is_available() {
        // Fudge course so it matches our fixtures.
        $course = get_site();
        $course->id = 2;

        $info = new mock_info($course);
        $condition = new condition((object) ['rc' => 'ABC']);

        $this->assertTrue($condition->is_available(false, $info, false, 3));
        $this->assertFalse($condition->is_available(true, $info, false, 3));
        $this->assertFalse($condition->is_available(false, $info, false, 4));
    }
}
