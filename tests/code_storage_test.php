<?php

namespace availability_releasecode\tests;

use availability_releasecode\code_storage;

class code_storage_test extends \advanced_testcase {

    public function setUp() {
        $this->resetAfterTest();

        $data = include(__DIR__.'/fixtures/codes.php');
        $this->loadDataSet($this->createArrayDataSet($data));
    }

    public function test_get_codes() {
        $storage = new code_storage();
        $this->assertEquals(array(1 => 'ABC', 2 => '123'), $storage->get_codes(2, 3));
        $this->assertEquals(array(), $storage->get_codes(2, 4));
    }

    public function test_has_code() {
        $storage = new code_storage();
        $this->assertTrue($storage->has_code(2, 3, 'ABC'));
        $this->assertTrue($storage->has_code(2, 3, '123'));
        $this->assertFalse($storage->has_code(2, 3, 'XYZ'), 'Does not have this code');
        $this->assertFalse($storage->has_code(2, 3, 'XYZ'), 'Wrong course');
        $this->assertTrue($storage->has_code(3, 4, 'XYZ'));
    }

    public function test_set_code() {
        global $DB;

        $storage = new code_storage();
        $this->assertTrue($storage->set_code(2, 3, '456'), 'Adding new code');
        $this->assertTrue($DB->record_exists('availability_releasecode', array('courseid' => 2, 'userid' => 3, 'code' => '456')));

        $this->assertFalse($storage->set_code(2, 3, 'ABC'), 'Already has this code');
        $this->assertFalse($storage->set_code(2, 3, '123'), 'Already has this code');

        $this->assertTrue($storage->set_code(3, 3, '123'), 'Different course');
        $this->assertTrue($DB->record_exists('availability_releasecode', array('courseid' => 3, 'userid' => 3, 'code' => '123')));
    }

    public function test_unset_code() {
        global $DB;

        $storage = new code_storage();
        $this->assertFalse($storage->unset_code(2, 3, '456'), 'Code does not exist');

        $this->assertTrue($storage->unset_code(2, 3, 'ABC'), 'Code removed');
        $this->assertFalse($DB->record_exists('availability_releasecode', array('courseid' => 2, 'userid' => 3, 'code' => 'ABC')));

        $this->assertTrue($storage->unset_code(2, 3, '123'), 'Code removed');
        $this->assertFalse($DB->record_exists('availability_releasecode', array('courseid' => 2, 'userid' => 3, 'code' => '123')));
    }
}