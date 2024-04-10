<?php

namespace availability_releasecode;

/**
 * Internal class
 *
 * This class is responsible for the storage of
 * release codes.
 *
 * @package availability_releasecode
 */
class code_storage {
    /**
     * @var \moodle_database
     */
    protected $db;

    public function __construct(\moodle_database $db = null) {
        global $DB;

        if (is_null($db)) {
            $db = $DB;
        }
        $this->db = $db;
    }

    /**
     * @param int $courseid
     * @param int $userid
     * @param null|string $code
     * @return array
     */
    protected function data($courseid, $userid, $code = null) {
        $data = ['courseid' => $courseid, 'userid' => $userid];
        if (!is_null($code)) {
            $data['code'] = $code;
        }
        return $data;
    }

    /**
     * Return a case insensitive select for searching for a specific user code in a course.
     *
     * @return string
     */
    protected function code_select() {
        return 'courseid = ? AND userid = ? AND '.$this->db->sql_like('code', '?', false);
    }

    /**
     * Get release codes for a user
     *
     * @param int $courseid
     * @param int $userid
     * @return array
     */
    public function get_codes($courseid, $userid) {
        return $this->db->get_records_menu(
            'availability_releasecode', $this->data($courseid, $userid), '', 'id, code'
        );
    }

    /**
     * Determine if a user has a release code in a course
     *
     * @param int $courseid
     * @param int $userid
     * @param string $code
     * @return bool
     */
    public function has_code($courseid, $userid, $code) {
        return $this->db->record_exists_select(
            'availability_releasecode', $this->code_select(), $this->data($courseid, $userid, $code)
        );
    }

    /**
     * Set a release code for a user in a course
     *
     * @param int $courseid
     * @param int $userid
     * @param string $code
     * @return bool
     */
    public function set_code($courseid, $userid, $code) {
        if ($this->has_code($courseid, $userid, $code)) {
            return false;
        }
        $this->db->insert_record('availability_releasecode', (object) $this->data($courseid, $userid, $code), false);

        return true;
    }

    /**
     * Remove a release code for a user in a course
     *
     * @param int $courseid
     * @param int $userid
     * @param string $code
     * @return bool
     */
    public function unset_code($courseid, $userid, $code) {
        if (!$this->has_code($courseid, $userid, $code)) {
            return false;
        }
        $this->db->delete_records_select('availability_releasecode', $this->code_select(), $this->data($courseid, $userid, $code));

        return true;
    }

    /**
     * Remove all release codes in a course.
     *
     * @param int $courseid
     */
    public function unset_course_codes($courseid) {
        $this->db->delete_records('availability_releasecode', ['courseid' => $courseid]);
    }

    /**
     * Remove all release codes for a user.
     *
     * @param int $userid
     */
    public function unset_user_codes($userid) {
        $this->db->delete_records('availability_releasecode', ['userid' => $userid]);
    }

    /**
     * Returns a list of user IDs who have one or more
     * release codes in a course.
     *
     * @param int $courseid
     * @return array
     */
    public function get_users_with_any_code($courseid) {
        return $this->db->get_records_sql_menu('
            SELECT DISTINCT userid id, userid
              FROM {availability_releasecode}
             WHERE courseid = ?
        ', [$courseid]);
    }
}