<?php
/**
 * Cache Definitions
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 **/

defined('MOODLE_INTERNAL') || die();

$definitions = array(
    // Cache user's course release codes.
    'releasecodes' => array(
        'mode'                   => cache_store::MODE_APPLICATION,
        'simplekeys'             => true,
        'simpledata'             => true,
        'staticacceleration'     => true,
        'staticaccelerationsize' => 20,
        'requireidentifiers'     => array(
            'courseid'
        ),
    ),
);