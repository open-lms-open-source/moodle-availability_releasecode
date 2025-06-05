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
/**
 * Release code condition.
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 */

namespace availability_releasecode;

use core_availability\condition as base_condition;
use core_availability\info;

defined('MOODLE_INTERNAL') || die();

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
     * @throws \core\exception\coding_exception If invalid data structure.
     */
    public function __construct($structure) {
        $this->releasecode = $structure->rc;
    }

    public function save() {
        return (object) ['type' => 'releasecode', 'rc' => $this->releasecode];
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
