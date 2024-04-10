<?php
/**
 * Event observers
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 **/

defined('MOODLE_INTERNAL') || die();

$observers = [
    [
        'eventname' => 'core\event\user_deleted',
        'callback'  => 'availability_releasecode\observer::user_deleted',
    ],
    [
        'eventname' => 'core\event\course_content_deleted',
        'callback'  => 'availability_releasecode\observer::course_content_deleted',
    ],
];
