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
 * Defined caches used internally by the plugin.
 *
 * @package   mod_assign
 * @copyright 2021 Shamim Rezaie <shamim@powereduc.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

defined('POWEREDUC_INTERNAL') || die();

$definitions = [
    'overrides' => [
        'mode' => cache_store::MODE_APPLICATION,
        'simplekeys' => true,
        'datasource' => '\mod_assign\cache\overrides',
    ],
];
