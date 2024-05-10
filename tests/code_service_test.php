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

use availability_releasecode\code_service;
use availability_releasecode\code_storage;

defined('MOODLE_INTERNAL') || die();

require_once(__DIR__.'/../../../../cache/classes/dummystore.php');

class code_service_test extends \advanced_testcase {

    public function setUp(): void {
        $this->resetAfterTest();

        $data = include(__DIR__.'/fixtures/codes.php');
        $this->dataset_from_array($data)->to_database();
    }

    public function test_get_codes() {
        $codes = [1 => 'ABC', 2 => '123'];

        $storage = $this->getMockBuilder('\availability_releasecode\code_storage')
            ->disableOriginalConstructor()
            ->getMock();

        $storage->expects($this->once())
            ->method('get_codes')
            ->will($this->returnValue($codes));

        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => 2]);
        $service = new code_service($cache, $storage);

        $this->assertEquals($codes, $service->get_codes(2, 3));
        $this->assertEquals($codes, $service->get_codes(2, 3), 'Ensure the cache is used instead of the storage');
    }

    public function test_has_code() {
        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => 2]);
        $service = new code_service($cache, new code_storage());
        $this->assertTrue($service->has_code(2, 3, 'ABC'));
        $this->assertTrue($service->has_code(2, 3, 'aBc'), 'Release codes should be case insensitive');
        $this->assertTrue($service->has_code(2, 3, '123'));
        $this->assertFalse($service->has_code(2, 3, 'XYZ'), 'Does not have this code');
        $this->assertFalse($service->has_code(2, 3, 'XYZ'), 'Wrong course');
        $this->assertTrue($service->has_code(3, 4, 'XYZ'));
    }

    public function test_set_code() {
        global $DB;

        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => 2]);
        $service = new code_service($cache, new code_storage());

        $service->set_code(2, 3, '456');
        $this->assertTrue($DB->record_exists('availability_releasecode', ['courseid' => 2, 'userid' => 3, 'code' => '456']));

        $service->set_code(3, 3, '123');
        $this->assertTrue($DB->record_exists('availability_releasecode', ['courseid' => 3, 'userid' => 3, 'code' => '123']));
    }

    public function test_unset_code() {
        global $DB;

        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => 2]);
        $service = new code_service($cache, new code_storage());

        $service->unset_code(2, 3, 'ABC');
        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 2, 'userid' => 3, 'code' => 'ABC']));

        $service->unset_code(2, 3, '123');
        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 2, 'userid' => 3, 'code' => '123']));
    }

    public function test_unset_course_codes() {
        global $DB;

        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => 2]);
        $service = new code_service($cache, new code_storage());

        $this->assertTrue($service->has_code(2, 3, 'ABC')); // Primes the cache.

        $service->unset_course_codes(2);
        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 2]));

        $this->assertFalse($service->has_code(2, 3, 'ABC'));  // Ensures cache is reset.
    }
}
