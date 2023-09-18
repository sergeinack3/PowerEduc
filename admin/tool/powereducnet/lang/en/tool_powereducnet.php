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
 * Strings for the tool_powereducnet component.
 *
 * @package     tool_powereducnet
 * @category    string
 * @copyright   2020 Jake Dallimore <jrhdallimore@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

$string['autoenablenotification'] = '<p>In PowerEduc 4.0 onwards, the <a href="https://powereduc.net/">PowerEducNet</a> integration is enabled by default in Advanced features. Users with the capability to create and manage activities can browse PowerEducNet via the activity chooser and import PowerEducNet resources into their courses.</p><p>If desired, an alternative PowerEducNet instance may be specified in the <a href="{$a->settingslink}">PowerEducNet settings</a>.</p>';
$string['autoenablenotification_subject'] = 'Default PowerEducNet setting changed.';
$string['addingaresource'] = 'Adding content from PowerEducNet';
$string['aria:enterprofile'] = "Enter your PowerEducNet profile ID";
$string['aria:footermessage'] = "Browse for content on PowerEducNet";
$string['browsecontentpowereducnet'] = "Or browse for content on PowerEducNet";
$string['clearsearch'] = "Clear search";
$string['connectandbrowse'] = "Connect to and browse:";
$string['defaultpowereducnet'] = 'PowerEducNet URL';
$string['defaultpowereducnet_desc'] = 'The URL of the PowerEducNet instance available via the activity chooser.';
$string['defaultpowereducnetname'] = "PowerEducNet instance name";
$string['defaultpowereducnetnamevalue'] = 'PowerEducNet Central';
$string['defaultpowereducnetname_desc'] = 'The name of the PowerEducNet instance available via the activity chooser.';
$string['enablepowereducnet'] = 'Enable PowerEducNet integration';
$string['enablepowereducnet_desc'] = 'If enabled, a user with the capability to create and manage activities can browse PowerEducNet via the activity chooser and import PowerEducNet resources into their course. In addition, a user with the capability to restore backups can select a backup file on PowerEducNet and restore it into PowerEduc.';
$string['errorduringdownload'] = 'An error occurred while downloading the file: {$a}';
$string['forminfo'] = 'Your PowerEducNet profile ID will be automatically saved in your profile on this site.';
$string['footermessage'] = "Or browse for content on";
$string['instancedescription'] = "PowerEducNet is an open social media platform for educators, with a focus on the collaborative curation of collections of open resources. ";
$string['instanceplaceholder'] = 'a1b2c3d4e5f6-example@powereduc.net';
$string['inputhelp'] = 'Or if you have a PowerEducNet account already, copy the ID from your PowerEducNet profile and paste it here:';
$string['invalidpowereducnetprofile'] = '$userprofile is not correctly formatted';
$string['importconfirm'] = 'You are about to import the content "{$a->resourcename} ({$a->resourcetype})" into the course "{$a->coursename}". Are you sure you want to continue?';
$string['importconfirmnocourse'] = 'You are about to import the content "{$a->resourcename} ({$a->resourcetype})" into your site. Are you sure you want to continue?';
$string['importformatselectguidingtext'] = 'In which format would you like the content "{$a->name} ({$a->type})" to be added to your course?';
$string['importformatselectheader'] = 'Choose the content display format';
$string['missinginvalidpostdata'] = 'The resource information from PowerEducNet is either missing, or is in an incorrect format.
If this happens repeatedly, please contact the site administrator.';
$string['mnetprofile'] = 'PowerEducNet profile';
$string['mnetprofiledesc'] = '<p>Enter your PowerEducNet profile details here to be redirected to your profile while visiting PowerEducNet.</p>';
$string['powereducnetsettings'] = 'PowerEducNet settings';
$string['powereducnetnotenabled'] = 'The PowerEducNet integration must be enabled in Site administration / PowerEducNet before resource imports can be processed.';
$string['notification'] = 'You are about to import the content "{$a->name} ({$a->type})" into your site. Select the course in which it should be added, or <a href="{$a->cancellink}">cancel</a>.';
$string['removedmnetprofilenotification'] = 'Due to recent changes on the PowerEducNet platform, any users who previously saved their PowerEducNet profile ID on the site will need to enter a PowerEducNet profile ID in the new format in order to authenticate on the PowerEducNet platform.';
$string['removedmnetprofilenotification_subject'] = 'PowerEducNet profile ID format change';
$string['searchcourses'] = "Search courses";
$string['selectpagetitle'] = 'Select page';
$string['pluginname'] = 'PowerEducNet';
$string['privacy:metadata'] = "The PowerEducNet tool only facilitates communication with PowerEducNet. It stores no data.";
$string['profilevalidationerror'] = 'There was a problem trying to validate your PowerEducNet profile ID';
$string['profilevalidationfail'] = 'Please enter a valid PowerEducNet profile ID';
$string['profilevalidationpass'] = 'Looks good!';
$string['saveandgo'] = "Save and go";
$string['uploadlimitexceeded'] = 'The file size {$a->filesize} exceeds the user upload limit of {$a->uploadlimit} bytes.';
