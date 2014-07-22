<?php
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
        $code  = new backup_nested_element('code', array('id'), array('userid', 'code'));

        $pluginwrapper->add_child($codes);
        $codes->add_child($code);

        $code->set_source_table('availability_releasecode', array('courseid' => backup::VAR_COURSEID));
        $code->annotate_ids('user', 'userid');
    }
}