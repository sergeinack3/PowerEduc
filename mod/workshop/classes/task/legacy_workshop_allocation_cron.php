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
 * Legacy workshop allocation plugins cron.
 *
 * @package     mod_workshop
 * @copyright   2018 Simey Lameze <simey@powereduc.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace mod_workshop\task;

defined('POWEREDUC_INTERNAL') || die();

/**
 * Legacy workshop allocation plugins cron.
 *
 * @package     mod_workshop
 * @copyright   2018 Simey Lameze <simey@powereduc.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class legacy_workshop_allocation_cron extends \core\task\scheduled_task {

    public function get_name() {
        return get_string('legacyallocationplugincron', 'mod_workshop');
    }

    /**
     * Execute all workshop allocation methods plugins cron tasks.
     */
    public function execute() {
        cron_execute_plugin_type('workshopallocation', 'workshop allocation methods');
    }
}
