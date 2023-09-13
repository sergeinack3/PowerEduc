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
 * Legacy Cron Quiz Reports Task
 *
 * @package    quiz_statistics
 * @copyright  2017 Michael Hughes, University of Strathclyde
 * @author Michael Hughes <michaelhughes@strath.ac.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('POWEREDUC_INTERNAL') || die();

$tasks = [
    [
        'classname' => 'quiz_statistics\task\recalculate',
        'blocking' => 0,
        'minute' => 'R',
        'hour' => '*/4',
        'day' => '*',
        'dayofweek' => '*',
        'month' => '*'
    ]
];
