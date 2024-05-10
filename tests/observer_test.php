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

class observer_test extends \advanced_testcase {

    public function setUp(): void {
        $this->resetAfterTest();
    }

    public function test_user_deleted() {
        $user = $this->getDataGenerator()->create_user();

        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => 2]);
        $storage = new code_storage();
        $service = new code_service($cache, $storage);
        $service->set_code(2, $user->id, 'ABC');

        $this->assertTrue($storage->has_code(2, $user->id, 'ABC'));

        delete_user($user);

        // Using storage instead of service because the cache is not
        // purged for user deletion.
        $this->assertFalse($storage->has_code(2, $user->id, 'ABC'));
    }

    public function test_course_content_deleted() {
        $user   = $this->getDataGenerator()->create_user();
        $course = $this->getDataGenerator()->create_course();

        $cache   = \cache::make('availability_releasecode', 'releasecodes', ['courseid' => $course->id]);
        $service = new code_service($cache, new code_storage());
        $service->set_code($course->id, $user->id, 'ABC');

        $this->assertTrue($service->has_code($course->id, $user->id, 'ABC'));

        remove_course_contents($course->id, false);

        $this->assertFalse($service->has_code($course->id, $user->id, 'ABC'));
    }
}
