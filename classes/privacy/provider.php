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

namespace availability_releasecode\privacy;

use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\userlist;
use \core_privacy\local\request\writer;
use \core_privacy\local\metadata\collection;
use \core_privacy\local\request\transform;
use \core_privacy\local\request\approved_contextlist;
use \core_privacy\local\request\helper as request_helper;

/**
 * Availability password - Privacy provider
 *
 * @package    availability_releasecode
 * @copyright  Open LMS
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements \core_privacy\local\metadata\provider, \core_privacy\local\metadata\null_provider {

    /**
     * Returns meta data about this system.
     *
     * @param collection $collection The initialised item collection to add items to.
     *
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection) : collection {
        $collection->add_database_table(
            'availability_releasecode',
            [
                'courseid' => 'privacy:metadata:availability_releasecode:courseid',
                'userid' => 'privacy:metadata:availability_releasecode:userid',
                'code' => 'privacy:metadata:availability_releasecode:code',
            ],
            'privacy:metadata:availability_releasecode'
        );

        return $collection;
    }

    /**
     * Get the language string identifier with the component's language
     * file to explain why this plugin stores no data.
     *
     * @return  string
     */
    public static function get_reason() : string {
        return 'privacy:reason';
    }
}
