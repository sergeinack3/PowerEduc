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
 * Import files from skydrive.
 *
 * @package    repository_onedrive
 * @copyright  2017 Damyon Wiese <damyon@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$PAGE->set_url('/repository/onedrive/importskydrive.php');
$PAGE->set_context(context_system::instance());
$strheading = get_string('importskydrivefiles', 'repository_onedrive');
$PAGE->set_title($strheading);
$PAGE->set_heading($strheading);

require_login();

require_capability('powereduc/site:config', context_system::instance());

$confirm = optional_param('confirm', false, PARAM_BOOL);

if ($confirm) {
    require_sesskey();
    require_once($CFG->dirroot . '/repository/lib.php');
    require_once($CFG->dirroot . '/repository/onedrive/lib.php');

    if (repository_onedrive::import_skydrive_files()) {
        $mesg = get_string('skydrivefilesimported', 'repository_onedrive');
        redirect(new powereduc_url('/admin/repository.php'), $mesg, null, \core\output\notification::NOTIFY_SUCCESS);
    } else {
        $mesg = get_string('skydrivefilesnotimported', 'repository_onedrive');
        redirect(new powereduc_url('/admin/repository.php'), $mesg, null, \core\output\notification::NOTIFY_ERROR);
    }
} else {
    $continueurl = new powereduc_url('/repository/onedrive/importskydrive.php', ['confirm' => true]);
    $cancelurl = new powereduc_url('/admin/repository.php');
    echo $OUTPUT->header();
    echo $OUTPUT->confirm(get_string('confirmimportskydrive', 'repository_onedrive'), $continueurl, $cancelurl);
    echo $OUTPUT->footer();
}
