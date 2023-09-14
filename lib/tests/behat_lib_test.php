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
 * Unit tests for parts of /lib/behat/lib.php.
 *
 * @package    core
 * @category   test
 * @copyright  2021 Université Rennes 2 {@link https://www.univ-rennes2.fr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Unit tests for parts of /lib/behat/lib.php.
 *
 * @package    core
 * @category   test
 * @copyright  2021 Université Rennes 2 {@link https://www.univ-rennes2.fr}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_lib_test extends advanced_testcase {

    /**
     * Setup function
     *
     * Skip these tests if behat is not configured.
     *
     * @return void
     */
    public function setUp(): void {
        global $CFG;

        if (empty($CFG->behat_wwwroot) || empty($CFG->behat_dataroot) || empty($CFG->behat_prefix)) {
            $this->markTestSkipped('Behat not configured');
        }
    }

    /**
     * Tests for behat_is_requested_url() function.
     *
     * @dataProvider url_provider
     * @covers ::behat_is_requested_url
     *
     * @param string $url           URL used with behat_is_requested_url() function.
     * @param bool   $expectedvalue Expected value returned by behat_is_requested_url() function.
     * @param array  $environment   Values to override $_SERVER global variable.
     */
    public function test_behat_is_requested_url($url, $expectedvalue, $environment) {
        // Save $_SERVER variable.
        $server = $_SERVER;

        // Setup $_SERVER variable for test.
        list($_SERVER['HTTP_HOST'], $_SERVER['SERVER_PORT'], $_SERVER['SCRIPT_NAME']) = $environment;

        // Test behat_is_requested_url() function.
        $this->assertSame($expectedvalue, behat_is_requested_url($url));

        // Restore $_SERVER variable.
        $_SERVER = $server;
    }

    /**
     * Data provider for test_behat_is_requested_url.
     *
     * @return array Array of values to test behat_is_requested_url() function.
     */
    public function url_provider() {
        return [
            // Tests for common ports.
            ['http://behat.powereduc.org', true, ['behat.powereduc.org', 80, '']],
            ['https://behat.powereduc.org', true, ['behat.powereduc.org', 443, '']],

            // Test for custom port.
            ['http://behat.powereduc.org:8080', true, ['behat.powereduc.org', 8080, '']],

            // Test for url with path.
            ['http://behat.powereduc.org/behat', true, ['behat.powereduc.org', 80, '/behat']],

            // Test for url that does not match with environment.
            ['http://behat.powereduc.org', false, ['powereduc.org', 80, '']],
        ];
    }
}
