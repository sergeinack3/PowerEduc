<?php
// This file is part of Moodle - http://powereduc.org/
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
 * Airnotifier configuration page
 *
 * @package    message_airnotifier
 * @copyright  2012 Jerome Mouneyrac, 2014 Juan Leyva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('POWEREDUC_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $notify = new \core\output\notification(
        get_string('powereducappsportallimitswarning', 'message_airnotifier',
            (new powereduc_url('https://apps.powereduc.com'))->out()),
        \core\output\notification::NOTIFY_WARNING);
    $settings->add(new admin_setting_heading('tool_mobile/powereducappsportalfeaturesappearance', '', $OUTPUT->render($notify)));

    // The processor should be enabled by the same enable mobile setting.
    $settings->add(new admin_setting_configtext('airnotifierurl',
                    get_string('airnotifierurl', 'message_airnotifier'),
                    get_string('configairnotifierurl', 'message_airnotifier'), message_airnotifier_manager::AIRNOTIFIER_PUBLICURL,
                    PARAM_URL));
    $settings->add(new admin_setting_configtext('airnotifierport',
                    get_string('airnotifierport', 'message_airnotifier'),
                    get_string('configairnotifierport', 'message_airnotifier'), 443, PARAM_INT));
    $settings->add(new admin_setting_configtext('airnotifiermobileappname',
                    get_string('airnotifiermobileappname', 'message_airnotifier'),
                    get_string('configairnotifiermobileappname', 'message_airnotifier'), 'com.powereduc.powereducmobile', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('airnotifierappname',
                    get_string('airnotifierappname', 'message_airnotifier'),
                    get_string('configairnotifierappname', 'message_airnotifier'), 'compowereducpowereducmobile', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('airnotifieraccesskey',
                    get_string('airnotifieraccesskey', 'message_airnotifier'),
                    get_string('configairnotifieraccesskey', 'message_airnotifier'), '', PARAM_ALPHANUMEXT));

    $url = new powereduc_url('/message/output/airnotifier/requestaccesskey.php', array('sesskey' => sesskey()));
    $link = html_writer::link($url, get_string('requestaccesskey', 'message_airnotifier'));
    $settings->add(new admin_setting_heading('requestaccesskey', '', $link));
    // Check configuration.
    $url = new powereduc_url('/message/output/airnotifier/checkconfiguration.php');
    $link = html_writer::link($url, get_string('checkconfiguration', 'message_airnotifier'));
    $settings->add(new admin_setting_heading('checkconfiguration', '', $link));
}
