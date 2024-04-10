<?php

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
