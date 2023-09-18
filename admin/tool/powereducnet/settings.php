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
 * Puts the plugin actions into the admin settings tree.
 *
 * @package     tool_powereducnet
 * @copyright   2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

if ($hassiteconfig) {
    // Add an enable subsystem setting to the "Advanced features" settings page.
    $optionalsubsystems = $ADMIN->locate('optionalsubsystems');
    $optionalsubsystems->add(new admin_setting_configcheckbox('tool_powereducnet/enablepowereducnet',
        new lang_string('enablepowereducnet', 'tool_powereducnet'),
        new lang_string('enablepowereducnet_desc', 'tool_powereducnet'),
        1, 1, 0)
    );

    // Create a PowerEducNet category.
    if (get_config('tool_powereducnet', 'enablepowereducnet')) {
        $ADMIN->add('root', new admin_category('powereducnet', get_string('pluginname', 'tool_powereducnet')));
        // Our settings page.
        $settings = new admin_settingpage('tool_powereducnet', get_string('powereducnetsettings', 'tool_powereducnet'));
        $ADMIN->add('powereducnet', $settings);

        $temp = new admin_setting_configtext('tool_powereducnet/defaultpowereducnetname',
            get_string('defaultpowereducnetname', 'tool_powereducnet'), new lang_string('defaultpowereducnetname_desc', 'tool_powereducnet'),
            new lang_string('defaultpowereducnetnamevalue', 'tool_powereducnet'));
        $settings->add($temp);

        $temp = new admin_setting_configtext('tool_powereducnet/defaultpowereducnet', get_string('defaultpowereducnet', 'tool_powereducnet'),
            new lang_string('defaultpowereducnet_desc', 'tool_powereducnet'), 'https://powereduc.net');
        $settings->add($temp);

    }
}
