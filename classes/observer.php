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
 * Event observer
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 */

namespace availability_releasecode;

use core\event\course_content_deleted;
use core\event\user_deleted;


/**
 * Event observer
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 */
class observer {
    /**
     * On user delete, remove all their earned release codes.
     *
     * @param user_deleted $event
     */
    public static function user_deleted(user_deleted $event) {
        // In this scenario, don't worry about cache since user
        // is being deleted and dirty read shouldn't be possible.
        $storage = new code_storage();
        $storage->unset_user_codes($event->objectid);
    }

    /**
     * On course content delete, remove all earned
     * release codes in the course.
     *
     * @param course_content_deleted $event
     */
    public static function course_content_deleted(course_content_deleted $event) {
        code_service::factory($event->objectid)->unset_course_codes($event->objectid);
    }
}
