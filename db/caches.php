<?php
/**
 * Cache Definitions
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 **/

$definitions = [
    // Cache user's course release codes.
    'releasecodes' => [
        'mode'                   => cache_store::MODE_APPLICATION,
        'simplekeys'             => true,
        'simpledata'             => true,
        'staticacceleration'     => true,
        'staticaccelerationsize' => 20,
        'requireidentifiers'     => [
            'courseid',
        ],
    ],
];