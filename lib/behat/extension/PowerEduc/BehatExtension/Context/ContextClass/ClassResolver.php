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

namespace PowerEduc\BehatExtension\Context\ContextClass;

use Behat\Behat\Context\ContextClass\ClassResolver as Resolver;

// phpcs:disable powereduc.NamingConventions.ValidFunctionName.LowercaseMethod

/**
 * PowerEduc behat context class resolver.
 *
 * Resolves arbitrary context strings into a context classes.
 *
 * @see ContextEnvironmentHandler
 *
 * @package    core
 * @copyright  2104 Rajesh Taneja <rajesh@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
final class ClassResolver implements Resolver {

    /** @var array keep list of all behat contexts in powereduc. */
    private $powereducbehatcontexts = null;

    /**
     * Constructor for ClassResolver class.
     *
     * @param array $parameters list of params provided to powereduc.
     */
    public function __construct($parameters) {
        $this->powereducbehatcontexts = $parameters['steps_definitions'];
    }
    /**
     * Checks if resolvers supports provided class.
     * PowerEduc behat context class starts with behat_
     *
     * @param string $contextstring
     * @return Boolean
     */
    public function supportsClass($contextstring) {
        return (strpos($contextstring, 'behat_') === 0);
    }

    /**
     * Resolves context class.
     *
     * @param string $contextclass
     * @return string context class.
     */
    public function resolveClass($contextclass) {
        if (!is_array($this->powereducbehatcontexts)) {
            throw new \RuntimeException('There are no PowerEduc context with steps definitions');
        }

        // Using the key as context identifier load context class.
        if (
            !empty($this->powereducbehatcontexts[$contextclass]) &&
            (file_exists($this->powereducbehatcontexts[$contextclass]))
        ) {
            require_once($this->powereducbehatcontexts[$contextclass]);
        } else {
            throw new \RuntimeException('PowerEduc behat context "' . $contextclass . '" not found');
        }
        return $contextclass;
    }
}
