<?php
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
