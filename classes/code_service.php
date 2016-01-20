<?php

namespace availability_releasecode;

/**
 * Release code service
 *
 * Main class for interacting with release
 * codes.  It makes use of a cache layer
 * to improve performance.
 *
 * @package availability_releasecode
 * @author Mark Nielsen
 **/
class code_service {
    /**
     * @var code_storage
     */
    protected $storage;

    /**
     * @var \cache
     */
    protected $cache;

    /**
     * @param \cache $cache Cache store to use
     * @param code_storage $storage
     */
    public function __construct(\cache $cache, code_storage $storage) {
        $this->cache   = $cache;
        $this->storage = $storage;
    }

    /**
     * Factory method for making standard instance
     *
     * @param $courseid
     * @return code_service
     */
    public static function factory($courseid) {
        return new self(
            \cache::make('availability_releasecode', 'releasecodes', array('courseid' => $courseid)),
            new code_storage()
        );
    }

    /**
     * Get release codes for a user
     *
     * @param int $courseid
     * @param int $userid
     * @return array
     */
    public function get_codes($courseid, $userid) {
        $codes = $this->cache->get((string) $userid);

        if ($codes === false) {
            $codes = $this->storage->get_codes($courseid, $userid);
            $this->cache->set((string) $userid, $codes);
        }
        return $codes;
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
        foreach ($this->get_codes($courseid, $userid) as $usercode) {
            if (\core_text::strtolower($usercode) === \core_text::strtolower($code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Set a release code for a user in a course
     *
     * @param int $courseid
     * @param int $userid
     * @param string $code
     */
    public function set_code($courseid, $userid, $code) {
        if ($this->storage->set_code($courseid, $userid, $code)) {
            $this->cache->delete((string) $userid);
        }
    }

    /**
     * Remove a release code for a user in a course
     *
     * @param int $courseid
     * @param int $userid
     * @param string $code
     */
    public function unset_code($courseid, $userid, $code) {
        if ($this->storage->unset_code($courseid, $userid, $code)) {
            $this->cache->delete((string) $userid);
        }
    }

    /**
     * Remove all release codes from a course.
     *
     * @param $courseid
     */
    public function unset_course_codes($courseid) {
        $userids = $this->storage->get_users_with_any_code($courseid);

        if (empty($userids)) {
            return;
        }
        $this->storage->unset_course_codes($courseid);
        $this->cache->delete_many($userids);
    }
}