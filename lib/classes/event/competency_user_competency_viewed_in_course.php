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
 * User competency viewed event.
 *
 * @package    core_competency
 * @copyright  2016 Issam Taboubi <issam.taboubi@umontreal.ca>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

use core\event\base;
use core_competency\user_competency_course;
use context_course;
defined('POWEREDUC_INTERNAL') || die();

/**
 * User competency viewed in course event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int competencyid: id of competency.
 * }
 *
 * @package    core_competency
 * @since      Moodle 3.1
 * @copyright  2016 Issam Taboubi <issam.taboubi@umontreal.ca>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class competency_user_competency_viewed_in_course extends base {

    /**
     * Convenience method to instantiate the event in course.
     *
     * @param user_competency_course $usercompetencycourse The user competency for the course.
     * @return self
     */
    public static function create_from_user_competency_viewed_in_course(user_competency_course $usercompetencycourse) {
        if (!$usercompetencycourse->get('id')) {
            throw new \coding_exception('The user competency course ID must be set.');
        }
        $params = array(
            'objectid' => $usercompetencycourse->get('id'),
            'relateduserid' => $usercompetencycourse->get('userid'),
            'other' => array(
                'competencyid' => $usercompetencycourse->get('competencyid')
            )
        );
        $coursecontext = context_course::instance($usercompetencycourse->get('courseid'));
        $params['contextid'] = $coursecontext->id;
        $params['courseid'] = $usercompetencycourse->get('courseid');

        $event = static::create($params);
        $event->add_record_snapshot(user_competency_course::TABLE, $usercompetencycourse->to_record());
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the user course competency with id '$this->objectid' "
                . "in course with id '$this->courseid'";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventusercompetencyviewedincourse', 'core_competency');
    }

    /**
     * Get URL related to the action
     *
     * @return \moodle_url
     */
    public function get_url() {
        return \core_competency\url::user_competency_in_course($this->relateduserid, $this->other['competencyid'],
            $this->courseid);
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = user_competency_course::TABLE;
    }

    /**
     * Get_objectid_mapping method.
     *
     * @return string the name of the restore mapping the objectid links to
     */
    public static function get_objectid_mapping() {
        return base::NOT_MAPPED;
    }

    /**
     * Custom validation.
     *
     * Throw \coding_exception notice in case of any problems.
     */
    protected function validate_data() {
        if (!$this->courseid) {
            throw new \coding_exception('The \'courseid\' value must be set.');
        }

        if (!isset($this->other) || !isset($this->other['competencyid'])) {
            throw new \coding_exception('The \'competencyid\' value must be set.');
        }
    }

}
