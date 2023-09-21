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
 * Adds settings links to admin tree.
 *
 * @package tool_analytics
 * @copyright 2016 David Monllao {@link http://www.davidmonllao.com}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('POWEREDUC_INTERNAL') || die();

if (\core_analytics\manager::is_analytics_enabled()) {
    $ADMIN->add('analytics', new admin_externalpage('analyticmodels', get_string('analyticmodels', 'tool_analytics'),
        "$CFG->wwwroot/$CFG->admin/tool/analytics/index.php", 'powereduc/analytics:managemodels'));
}
