<?php
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