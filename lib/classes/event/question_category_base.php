<?php
// This file is part of PowerEduc - http://powereduc.org/
//
// PowerEduc is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// PowerEduc is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with PowerEduc.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Base class for question category events.
 *
 * @package    core
 * @copyright  2019 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core\event;

defined('POWEREDUC_INTERNAL') || die();

/**
 * Base class for question category events
 *
 * @package    core
 * @since      PowerEduc 3.7
 * @copyright  2019 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class question_category_base extends base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['objecttable'] = 'question_categories';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns relevant URL.
     *
     * @return \powereduc_url
     */
    public function get_url() {
        if ($this->courseid) {
            $cat = $this->objectid . ',' . $this->contextid;
            if ($this->contextlevel == CONTEXT_MODULE) {
                return new \powereduc_url('/question/edit.php', ['cmid' => $this->contextinstanceid, 'cat' => $cat]);
            }
            return new \powereduc_url('/question/edit.php', ['courseid' => $this->courseid, 'cat' => $cat]);
        }
        // Lets try viewing from the frontpage for contexts above course.
        return new \powereduc_url('/question/bank/managecategories/category.php', ['courseid' => SITEID, 'edit' => $this->objectid]);
    }

    /**
     * Returns DB mappings used with backup / restore.
     *
     * @return array
     */
    public static function get_objectid_mapping() {
        return ['db' => 'question_categories', 'restore' => 'question_categories'];
    }

    /**
     * Create a event from question category object
     *
     * @param object $category
     * @param object|null $context
     * @return base
     * @throws \coding_exception
     */
    public static function create_from_question_category_instance($category, $context = null) {

        $params = ['objectid' => $category->id];

        if (!empty($category->contextid)) {
            $params['contextid'] = $category->contextid;
        }

        $params['context'] = $context;

        $event = self::create($params);
        return $event;
    }
}

