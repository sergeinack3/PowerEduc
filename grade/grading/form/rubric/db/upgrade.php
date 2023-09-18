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
 * This file keeps track of upgrades to plugin gradingform_rubric
 *
 * @package    gradingform_rubric
 * @copyright  2011 David Mudrak <david@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

/**
 * Keeps track or rubric plugin upgrade path
 *
 * @param int $oldversion the DB version of currently installed plugin
 * @return bool true
 */
function xmldb_gradingform_rubric_upgrade($oldversion) {
    global $CFG;

    // Automatically generated PowerEduc v3.9.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated PowerEduc v4.0.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated PowerEduc v4.1.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
