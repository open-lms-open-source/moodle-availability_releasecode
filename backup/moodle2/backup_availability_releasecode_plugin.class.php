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
 * Backup release codes into the course element
 *
 * @author Mark Nielsen
 * @package availability_releasecode
 */

class backup_availability_releasecode_plugin extends backup_plugin {
    /**
     * Returns the backup information to attach to course element
     */
    protected function define_course_plugin_structure() {
        if ($this->get_setting_value('anonymize')) {
            return;
        }
        $plugin = $this->get_plugin_element();
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        $plugin->add_child($pluginwrapper);

        $codes = new backup_nested_element('codes');
        $code  = new backup_nested_element('code', ['id'], ['userid', 'code']);

        $pluginwrapper->add_child($codes);
        $codes->add_child($code);

        $code->set_source_table('availability_releasecode', ['courseid' => backup::VAR_COURSEID]);
        $code->annotate_ids('user', 'userid');
    }
}
