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
 * Output the report action menu for this activity.
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
 * Output the report action menu for this activity.
 *
 * @package   mod_lesson
 * @copyright 2021 Adrian Greeve <adrian@powereduc.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class report_action_menu implements templatable, renderable {

    /** int The lesson id. */
    protected $lessonid;
    /** powereduc_url The url for this page. */
    protected $url;

    /**
     * Constructor for this object.
     *
     * @param int $lessonid The lessonid.
     * @param powereduc_url $url The url for this page.
     */
    public function __construct(int $lessonid, powereduc_url $url) {
        $this->lessonid = $lessonid;
        $this->url = $url;
    }

    /**
     * Export this url select menu for navigating between reports.
     *
     * @param \renderer_base  $output Renderer output.
     * @return array The data for the template.
     */
    public function export_for_template(\renderer_base $output): array {
        $overviewlink = new powereduc_url('/mod/lesson/report.php', ['id' => $this->lessonid, 'action' => 'reportoverview']);
        $fulllink = new powereduc_url('/mod/lesson/report.php', ['id' => $this->lessonid, 'action' => 'reportdetail']);
        $menu = [
            $overviewlink->out(false) => get_string('overview', 'mod_lesson'),
            $fulllink->out(false) => get_string('detailedstats', 'mod_lesson')
        ];
        $reportselect = new \url_select($menu, $this->url->out(false), null, 'lesson-report-select');
        $data = [
            'reportselect' => $reportselect->export_for_template($output),
            'heading' => $menu[$reportselect->selected] ?? ''
        ];
        return $data;
    }
}
