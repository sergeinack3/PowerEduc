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
 * Upgrade script for tool_powereducnet.
 *
 * @package    tool_powereducnet
 * @copyright  2020 Adrian Greeve <adrian@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

/**
 * Upgrade the plugin.
 *
 * @param int $oldversion
 * @return bool always true
 */
function xmldb_tool_powereducnet_upgrade(int $oldversion) {
    global $CFG, $DB;
    if ($oldversion < 2020060500) {

        // Grab some of the old settings.
        $categoryname = get_config('tool_powereducnet', 'profile_category');
        $profilefield = get_config('tool_powereducnet', 'profile_field_name');

        // Master version only!

        // Find out if we have a custom profile field for powereduc.net.
        $sql = "SELECT f.*
                  FROM {user_info_field} f
                  JOIN {user_info_category} c ON c.id = f.categoryid and c.name = :categoryname
                 WHERE f.shortname = :name";

        $params = [
            'categoryname' => $categoryname,
            'name' => $profilefield
        ];

        $record = $DB->get_record_sql($sql, $params);

        if (!empty($record)) {
            $userentries = $DB->get_recordset('user_info_data', ['fieldid' => $record->id]);
            $recordstodelete = [];
            foreach ($userentries as $userentry) {
                $data = (object) [
                    'id' => $userentry->userid,
                    'powereducnetprofile' => $userentry->data
                ];
                $DB->update_record('user', $data, true);
                $recordstodelete[] = $userentry->id;
            }
            $userentries->close();

            // Remove the user profile data, fields, and category.
            $DB->delete_records_list('user_info_data', 'id', $recordstodelete);
            $DB->delete_records('user_info_field', ['id' => $record->id]);
            $DB->delete_records('user_info_category', ['name' => $categoryname]);
            unset_config('profile_field_name', 'tool_powereducnet');
            unset_config('profile_category', 'tool_powereducnet');
        }

        upgrade_plugin_savepoint(true, 2020060500, 'tool', 'powereducnet');
    }

    if ($oldversion < 2020061501) {
        // Change the domain.
        $defaultpowereducnet = get_config('tool_powereducnet', 'defaultpowereducnet');

        if ($defaultpowereducnet === 'https://home.powereduc.net') {
            set_config('defaultpowereducnet', 'https://powereduc.net', 'tool_powereducnet');
        }

        // Change the name.
        $defaultpowereducnetname = get_config('tool_powereducnet', 'defaultpowereducnetname');

        if ($defaultpowereducnetname === 'PowerEduc HQ PowerEducNet') {
            set_config('defaultpowereducnetname', 'PowerEducNet Central', 'tool_powereducnet');
        }

        upgrade_plugin_savepoint(true, 2020061501, 'tool', 'powereducnet');
    }

    if ($oldversion < 2020061502) {
        // Disable the PowerEducNet integration by default till further notice.
        set_config('enablepowereducnet', 0, 'tool_powereducnet');

        upgrade_plugin_savepoint(true, 2020061502, 'tool', 'powereducnet');
    }

    // Automatically generated PowerEduc v3.9.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2022021600) {
        // This is a special case for if PowerEducNet integration has never been enabled,
        // or if defaultpowereducnet is not set for whatever reason.
        if (!get_config('tool_powereducnet', 'defaultpowereducnet')) {
            set_config('defaultpowereducnet', 'https://powereduc.net', 'tool_powereducnet');
            set_config('defaultpowereducnetname', get_string('defaultpowereducnetnamevalue', 'tool_powereducnet'), 'tool_powereducnet');
        }

        // Enable PowerEducNet and set it to display on activity chooser footer.
        // But only do this if we know for sure that the default PowerEducNet is a working one.
        if (get_config('tool_powereducnet', 'defaultpowereducnet') == 'https://powereduc.net') {
            set_config('enablepowereducnet', '1', 'tool_powereducnet');
            set_config('activitychooseractivefooter', 'tool_powereducnet');

            // Use an adhoc task to send a notification to admin stating PowerEducNet is automatically enabled after upgrade.
            $notificationtask = new tool_powereducnet\task\send_enable_notification();
            core\task\manager::queue_adhoc_task($notificationtask);
        }

        upgrade_plugin_savepoint(true, 2022021600, 'tool', 'powereducnet');
    }

    if ($oldversion < 2022021601) {

        $selectsql = "powereducnetprofile IS NOT NULL AND powereducnetprofile != ''";

        // If there are any users with PowerEducNet profile set.
        if ($DB->count_records_select('user', $selectsql)) {
            // Remove the value set for the PowerEducNet profile as this format can no longer be used to authenticate
            // PowerEducNet users.
            $DB->set_field_select('user', 'powereducnetprofile', '', $selectsql);

            // Use an adhoc task to send a notification to admin stating that the user data related to the linked
            // PowerEducNet profiles has been removed.
            $notificationtask = new tool_powereducnet\task\send_mnet_profiles_data_removed_notification();
            core\task\manager::queue_adhoc_task($notificationtask);
        }

        upgrade_plugin_savepoint(true, 2022021601, 'tool', 'powereducnet');
    }

    // Automatically generated PowerEduc v4.0.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated PowerEduc v4.1.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
