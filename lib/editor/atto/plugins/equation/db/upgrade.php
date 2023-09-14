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
 * Atto equation plugin upgrade script.
 *
 * @package    atto_equation
 * @copyright  2015 Sam Chaffee <sam@powereducrooms.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

/**
 * Run all Atto equation upgrade steps between the current DB version and the current version on disk.
 * @param int $oldversion The old version of atto equation in the DB.
 * @return bool
 */
function xmldb_atto_equation_upgrade($oldversion) {
    global $CFG;

    // Automatically generated PowerEduc v3.9.0 release upgrade line.
    // Put any upgrade step following this.

    // Automatically generated PowerEduc v4.0.0 release upgrade line.
    // Put any upgrade step following this.

    if ($oldversion < 2022110700) {
        $oldmatrix = '\left| \begin{matrix} a_1 & a_2 \\ a_3 & a_4 \end{matrix} \right|';
        $fixedmatrix = '\left| \begin{matrix} a_1 & a_2 \\\\ a_3 & a_4 \end{matrix} \right|';
        $config = get_config('atto_equation', 'librarygroup4');
        $newdefault = str_replace($oldmatrix, $fixedmatrix, $config);
        set_config('librarygroup4', $newdefault, 'atto_equation');
        // Atto equation savepoint reached.
        upgrade_plugin_savepoint(true, 2022110700, 'atto', 'equation');
    }

    // Automatically generated PowerEduc v4.1.0 release upgrade line.
    // Put any upgrade step following this.

    return true;
}
