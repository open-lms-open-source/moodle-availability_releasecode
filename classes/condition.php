<?php
/**
 * Release code condition.
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 */

namespace availability_releasecode;

use core_availability\condition as base_condition;
use core_availability\info;


/**
 * Release code condition.
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 */
class condition extends base_condition {
    /**
     * The required release code
     *
     * @var string
     */
    protected $releasecode;

    /**
     * Constructor.
     *
     * @param \stdClass $structure Data structure from JSON decode
     * @throws \coding_exception If invalid data structure.
     */
    public function __construct($structure) {
        $this->releasecode = $structure->rc;
    }

    public function save() {
        return (object) array('type' => 'releasecode', 'rc' => $this->releasecode);
    }

    public function is_available($not, info $info, $grabthelot, $userid) {
        $service = code_service::factory($info->get_course()->id);
        $allow   = $service->has_code($info->get_course()->id, $userid, $this->releasecode);

        if ($not) {
            $allow = !$allow;
        }
        return $allow;
    }

    public function get_description($full, $not, info $info) {
        return get_string('requiresreleasecode', 'availability_releasecode');
    }

    protected function get_debug_string() {
        return $this->releasecode;
    }
}
