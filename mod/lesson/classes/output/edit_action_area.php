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
 * Output the actionbar for this activity.
 *
 * @package   mod_lesson
 * @copyright 2021 Adrian Greeve <adrian@powereduc.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace mod_lesson\output;

use powereduc_url;
use templatable;
use renderable;

/**
 * Output the actionbar for this activity.
 *
 * @package   mod_lesson
 * @copyright 2021 Adrian Greeve <adrian@powereduc.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class edit_action_area implements templatable, renderable {

    /** @var int The course module ID. */
    protected $cmid;
    /** @var powereduc_url The current url for the page. */
    protected $currenturl;

    /**
     * Constructor for this object.
     *
     * @param int        $cmid       The course module ID.
     * @param powereduc_url $currenturl The current url for the page.
     */
    public function __construct(int $cmid, powereduc_url $currenturl) {
        $this->cmid = $cmid;
        $this->currenturl = $currenturl;
    }

    /**
     * Data for use with a template.
     *
     * @param \renderer_base $output render base output.
     * @return array Said data.
     */
    public function export_for_template(\renderer_base $output): array {

        $viewurl = new powereduc_url('/mod/lesson/edit.php', ['id' => $this->cmid, 'mode' => 'collapsed']);
        $fullviewurl = new powereduc_url('/mod/lesson/edit.php', ['id' => $this->cmid, 'mode' => 'full']);
        $menu = [
            $viewurl->out(false) => get_string('collapsed', 'mod_lesson'),
            $fullviewurl->out(false) => get_string('full', 'mod_lesson')
        ];

        $selectmenu = new \url_select($menu, $this->currenturl->out(false), null, 'mod_lesson_navigation_select');

        return [
            'back' => [
                'text' => get_string('back', 'core'),
                'link' => (new powereduc_url('/mod/lesson/view.php', ['id' => $this->cmid]))->out(false)
            ],
            'viewselect' => $selectmenu->export_for_template($output),
            'heading' => get_string('editinglesson', 'mod_lesson')
        ];
    }
}
