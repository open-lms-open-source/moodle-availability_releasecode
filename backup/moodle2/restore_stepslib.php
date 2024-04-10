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
 * Restore of legacy release code data for pre Joule 2.7
 */
class restore_releasecodes_structure_step extends restore_structure_step {
    /**
     * Only execute if we are including user completion info
     */
    protected function execute_condition() {
        return $this->get_setting_value('userscompletion');
    }

    /**
     * Function that will return the structure to be processed by this restore_step.
     * Must return one array of @restore_path_element elements
     */
    protected function define_structure() {
        return [
            new restore_path_element('releasecode', '/releasecodes/releasecode'),
        ];
    }

    public function process_releasecode($data) {
        global $DB;

        if (!$newuserid = $this->get_mappingid('user', $data['userid'])) {
            return;
        }
        $DB->insert_record('availability_releasecode', (object) [
            'courseid' => $this->get_courseid(),
            'userid'   => $newuserid,
            'code'     => $data['releasecode'],
        ]);
    }
}
