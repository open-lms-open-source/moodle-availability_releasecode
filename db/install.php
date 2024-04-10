<?php
/**
 * Installation
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 **/
function xmldb_availability_releasecode_install() {
    global $DB;

    $dbman = $DB->get_manager();

    if ($dbman->table_exists('user_release_codes') && $DB->get_dbfamily() === 'mysql') {
        // Seed table with data from user_release_codes.
        $DB->execute("
            INSERT INTO {availability_releasecode} (userid, courseid, code)
                 SELECT r.userid, r.courseid, r.releasecode
                   FROM {user_release_codes} r
        ");
    }
}
