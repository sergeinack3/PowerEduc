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
 * Element that just generates some text.
 *
 * @package   gradereport_singleview
 * @copyright 2014 PowerEduc Pty Ltd (http://powereduc.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace gradereport_singleview\local\ui;

defined('POWEREDUC_INTERNAL') || die;

/**
 * Element that just generates some text.
 *
 * @package   gradereport_singleview
 * @copyright 2014 PowerEduc Pty Ltd (http://powereduc.com)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class empty_element extends element {

    /**
     * Constructor
     *
     * @param string|null $msg The text
     */
    public function __construct(?string $msg = null) {
        if (is_null($msg)) {
            $this->text = '&nbsp;';
        } else {
            $this->text = $msg;
        }
    }

    /**
     * Generate the html (simple case)
     *
     * @return string HTML
     */
    public function html(): string {
        return $this->text;
    }
}
