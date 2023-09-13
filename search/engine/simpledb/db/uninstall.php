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
 * Uninstall code.
 *
 * @package    search_simpledb
 * @copyright  2016 Dan Poltawski <dan@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die;

/**
 * Plugin uninstall code.
 *
 * @package    search_simpledb
 * @copyright  2016 Dan Poltawski <dan@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function xmldb_search_simpledb_uninstall() {
    global $DB;

    switch ($DB->get_dbfamily()) {
        case 'postgres':
            $DB->execute("DROP INDEX {search_simpledb_title}");
            $DB->execute("DROP INDEX {search_simpledb_content}");
            $DB->execute("DROP INDEX {search_simpledb_description1}");
            $DB->execute("DROP INDEX {search_simpledb_description2}");
            break;
        case 'mysql':
            if ($DB->is_fulltext_search_supported()) {
                $DB->execute("ALTER TABLE {search_simpledb_index} DROP INDEX {search_simpledb_index_index}");
            }
            break;
        case 'mssql':
            if ($DB->is_fulltext_search_supported()) {
                $DB->execute("DROP FULLTEXT CATALOG {search_simpledb_catalog}");
            }
            break;
    }
}

