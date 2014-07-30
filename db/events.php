<?php
/**
 * Event observers
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 **/

defined('MOODLE_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => 'core\event\user_deleted',
        'callback'  => 'availability_releasecode\observer::user_deleted',
    ),
    array(
        'eventname' => 'core\event\course_content_deleted',
        'callback'  => 'availability_releasecode\observer::course_content_deleted',
    ),
);
