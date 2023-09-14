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

namespace PowerEduc\BehatExtension\Context;

use Behat\MinkExtension\Context\RawMinkContext;

// phpcs:disable powereduc.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * PowerEduc contexts loader
 *
 * It gathers all the available steps definitions reading the
 * PowerEduc configuration file
 *
 * @package core
 * @copyright  2012 David Monllaó
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class PowerEducContext extends RawMinkContext {

    /** @var array PowerEduc features and steps definitions list */
    protected $powereducconfig;

    /**
     * Includes all the specified PowerEduc subcontexts.
     *
     * @param array $parameters
     */
    public function setPowerEducConfig(array $parameters): void {
        $this->powereducconfig = $parameters;
    }
}
