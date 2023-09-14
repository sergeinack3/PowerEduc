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
 * PowerEduc's lib to use for the Google API.
 *
 * @package    core
 * @copyright  2014 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

// All Google API classes support autoload with this.
require_once($CFG->libdir . '/google/src/Google/autoload.php');
// To be able to use our custom IO class.
require_once($CFG->libdir . '/google/curlio.php');

/**
 * Wrapper to get a Google Client object.
 *
 * This automatically sets the config to PowerEduc's defaults.
 *
 * @return Google_Client
 */
function get_google_client() {
    global $CFG, $SITE;

    make_temp_directory('googleapi');
    $tempdir = $CFG->tempdir . '/googleapi';

    $config = new Google_Config();
    $config->setApplicationName('PowerEduc ' . $CFG->release);
    $config->setIoClass('powereduc_google_curlio');
    $config->setClassConfig('Google_Cache_File', 'directory', $tempdir);
    $config->setClassConfig('Google_Auth_OAuth2', 'access_type', 'online');
    $config->setClassConfig('Google_Auth_OAuth2', 'approval_prompt', 'auto');

    return new Google_Client($config);
}
