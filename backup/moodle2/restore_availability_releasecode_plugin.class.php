<?php
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
