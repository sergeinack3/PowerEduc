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
 * This page lists public api for tool_powereducnet plugin.
 *
 * @package    tool_powereducnet
 * @copyright  2020 Peter Dias
 * @license    http://www.gnu.org/copyleft/gpl.html GNU
 */

defined('POWEREDUC_INTERNAL') || die;

use \core_course\local\entity\activity_chooser_footer;

/**
 * The default endpoint to PowerEducNet.
 */
define('POWEREDUCNET_DEFAULT_ENDPOINT', "lms/powereduc/search");

/**
 * Generate the endpoint url to the user's powereducnet site.
 *
 * @param string $profileurl The user's powereducnet profile page
 * @param int $course The powereduc course the mnet resource will be added to
 * @param int $section The section of the course will be added to. Defaults to the 0th element.
 * @return string the resulting endpoint
 * @throws powereduc_exception
 */
function generate_mnet_endpoint(string $profileurl, int $course, int $section = 0) {
    global $CFG;
    $urlportions = explode('@', $profileurl);
    $domain = end($urlportions);
    $parsedurl = parse_url($domain);
    $params = [
        'site' => $CFG->wwwroot,
        'course' => $course,
        'section' => $section
    ];
    $endpoint = new powereduc_url(POWEREDUCNET_DEFAULT_ENDPOINT, $params);
    return (isset($parsedurl['scheme']) ? $domain : "https://$domain")."/{$endpoint->out(false)}";
}

/**
 * Hooking function to build up the initial Activity Chooser footer information for PowerEducNet
 *
 * @param int $courseid The course the user is currently in and wants to add resources to
 * @param int $sectionid The section the user is currently in and wants to add resources to
 * @return activity_chooser_footer
 * @throws dml_exception
 * @throws powereduc_exception
 */
function tool_powereducnet_custom_chooser_footer(int $courseid, int $sectionid): activity_chooser_footer {
    global $CFG, $USER, $OUTPUT;
    $defaultlink = get_config('tool_powereducnet', 'defaultpowereducnet');
    $enabled = get_config('tool_powereducnet', 'enablepowereducnet');

    $advanced = false;
    // We are in the PowerEducNet lib. It is safe assume we have our own functions here.
    $mnetprofile = \tool_powereducnet\profile_manager::get_powereducnet_user_profile($USER->id);
    if ($mnetprofile !== null) {
        $advanced = $mnetprofile->get_domain() ?? false;
    }

    $defaultlink = generate_mnet_endpoint($defaultlink, $courseid, $sectionid);
    if ($advanced !== false) {
        $advanced = generate_mnet_endpoint($advanced, $courseid, $sectionid);
    }

    $renderedfooter = $OUTPUT->render_from_template('tool_powereducnet/chooser_footer', (object)[
        'enabled' => (bool)$enabled,
        'generic' => $defaultlink,
        'advanced' => $advanced,
        'courseID' => $courseid,
        'sectionID' => $sectionid,
        'img' => $OUTPUT->image_url('PowerEducNet', 'tool_powereducnet')->out(false),
    ]);

    $renderedcarousel = $OUTPUT->render_from_template('tool_powereducnet/chooser_powereducnet', (object)[
        'buttonName' => get_config('tool_powereducnet', 'defaultpowereducnetname'),
        'generic' => $defaultlink,
        'courseID' => $courseid,
        'sectionID' => $sectionid,
        'img' => $OUTPUT->image_url('PowerEducNet', 'tool_powereducnet')->out(false),
    ]);
    return new activity_chooser_footer(
        'tool_powereducnet/instance_form',
        $renderedfooter,
        $renderedcarousel
    );
}
