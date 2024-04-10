<?php

namespace availability_releasecode\tests;

use availability_releasecode\code_storage;

class code_storage_test extends \advanced_testcase {

    public function setUp(): void {
        $this->resetAfterTest();

        $data = include(__DIR__.'/fixtures/codes.php');
        $this->dataset_from_array($data)->to_database();
    }

    public function test_get_codes() {
        $storage = new code_storage();
        $this->assertEquals([1 => 'ABC', 2 => '123'], $storage->get_codes(2, 3));
        $this->assertEquals([], $storage->get_codes(2, 4));
    }

    public function test_has_code() {
        $storage = new code_storage();
        $this->assertTrue($storage->has_code(2, 3, 'ABC'));
        $this->assertTrue($storage->has_code(2, 3, 'aBc'), 'Release codes should be case insensitive');
        $this->assertTrue($storage->has_code(2, 3, '123'));
        $this->assertFalse($storage->has_code(2, 3, 'XYZ'), 'Does not have this code');
        $this->assertFalse($storage->has_code(2, 3, 'XYZ'), 'Wrong course');
        $this->assertTrue($storage->has_code(3, 4, 'XYZ'));
    }

    public function test_set_code() {
        global $DB;

        $storage = new code_storage();
        $this->assertTrue($storage->set_code(2, 3, '456'), 'Adding new code');
        $this->assertTrue($DB->record_exists('availability_releasecode', ['courseid' => 2, 'userid' => 3, 'code' => '456']));

        $this->assertFalse($storage->set_code(2, 3, 'ABC'), 'Already has this code');
        $this->assertFalse($storage->set_code(2, 3, '123'), 'Already has this code');

        $this->assertTrue($storage->set_code(3, 3, '123'), 'Different course');
        $this->assertTrue($DB->record_exists('availability_releasecode', ['courseid' => 3, 'userid' => 3, 'code' => '123']));
    }

    public function test_unset_code() {
        global $DB;

        $storage = new code_storage();
        $this->assertFalse($storage->unset_code(2, 3, '456'), 'Code does not exist');

        $this->assertTrue($storage->unset_code(2, 3, 'ABC'), 'Code removed');
        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 2, 'userid' => 3, 'code' => 'ABC']));

        $this->assertTrue($storage->unset_code(3, 4, 'xYz'), 'Can do a case insensitive code unset');
        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 3, 'userid' => 4, 'code' => 'XYZ']));

        $this->assertTrue($storage->unset_code(2, 3, '123'), 'Code removed');
        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 2, 'userid' => 3, 'code' => '123']));
    }

    public function test_unset_course_codes() {
        global $DB;

        $storage = new code_storage();
        $storage->unset_course_codes(2);

        $this->assertFalse($DB->record_exists('availability_releasecode', ['courseid' => 2]));
    }

    public function test_unset_user_codes() {
        global $DB;

        $storage = new code_storage();
        $storage->unset_user_codes(3);

        $this->assertFalse($DB->record_exists('availability_releasecode', ['userid' => 3]));
    }

    public function test_get_users_with_any_code() {
        $storage = new code_storage();
        $this->assertEquals(['3' => '3'], $storage->get_users_with_any_code(2));
    }
}