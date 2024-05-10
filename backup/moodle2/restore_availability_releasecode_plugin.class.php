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
 * Restore release codes into the course element
 *
 * @author Mark Nielsen
 * @package availability_releasecode
 */
class restore_availability_releasecode_plugin extends restore_plugin {
    /**
     * Returns the paths to be handled by the plugin at course level
     */
    protected function define_course_plugin_structure() {
        if (!$this->get_setting_value('userscompletion')) {
            return [];
        }
        return [
            new restore_path_element('releasecode_code', $this->get_pathfor('/codes/code')),
        ];
    }

    /**
     * Restore a single release code
     *
     * @param array $data
     */
    public function process_releasecode_code($data) {
        global $DB;

        if (!$newuserid = $this->get_mappingid('user', $data['userid'])) {
            return;
        }
        $DB->insert_record('availability_releasecode', (object) [
            'courseid' => $this->task->get_courseid(),
            'userid'   => $newuserid,
            'code'     => $data['code'],
        ]);
    }
}
