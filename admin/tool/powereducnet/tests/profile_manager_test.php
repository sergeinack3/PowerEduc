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

namespace tool_powereducnet;

/**
 * Unit tests for the profile manager
 *
 * @package    tool_powereducnet
 * @category   test
 * @copyright  2020 Adrian Greeve <adrian@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class profile_manager_test extends \advanced_testcase {

    /**
     * Test that on this site we use the user table to hold powereduc net profile information.
     */
    public function test_official_profile_exists() {
        $this->assertTrue(\tool_powereducnet\profile_manager::official_profile_exists());
    }

    /**
     * Test a null is returned when the user's mnet profile field is not set.
     */
    public function test_get_powereducnet_user_profile_no_profile_set() {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();

        $result = \tool_powereducnet\profile_manager::get_powereducnet_user_profile($user->id);
        $this->assertNull($result);
    }

    /**
     * Test a null is returned when the user's mnet profile field is not set.
     */
    public function test_powereducnet_user_profile_creation_no_profile_set() {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user();

        $this->expectException(\powereduc_exception::class);
        $this->expectExceptionMessage(get_string('invalidpowereducnetprofile', 'tool_powereducnet'));
        $result = new \tool_powereducnet\powereducnet_user_profile("", $user->id);
    }

    /**
     * Test the return of a powereduc net profile.
     */
    public function test_get_powereducnet_user_profile() {
        $this->resetAfterTest();
        $user = $this->getDataGenerator()->create_user(['powereducnetprofile' => '@matt@hq.mnet']);

        $result = \tool_powereducnet\profile_manager::get_powereducnet_user_profile($user->id);
        $this->assertEquals($user->powereducnetprofile, $result->get_profile_name());
    }

    /**
     * Test the creation of a user profile category.
     */
    public function test_create_user_profile_category() {
        global $DB;
        $this->resetAfterTest();

        $basecategoryname = get_string('pluginname', 'tool_powereducnet');

        \tool_powereducnet\profile_manager::create_user_profile_category();
        $categoryname = \tool_powereducnet\profile_manager::get_category_name();
        $this->assertEquals($basecategoryname, $categoryname);
        \tool_powereducnet\profile_manager::create_user_profile_category();

        $recordcount = $DB->count_records('user_info_category', ['name' => $basecategoryname]);
        $this->assertEquals(1, $recordcount);

        // Test the duplication of categories to ensure a unique name is always used.
        $categoryname = \tool_powereducnet\profile_manager::get_category_name();
        $this->assertEquals($basecategoryname . 1, $categoryname);
        \tool_powereducnet\profile_manager::create_user_profile_category();
        $categoryname = \tool_powereducnet\profile_manager::get_category_name();
        $this->assertEquals($basecategoryname . 2, $categoryname);
    }

    /**
     * Test the creating of the custom user profile field to hold the powereduc net profile.
     */
    public function test_create_user_profile_text_field() {
        global $DB;
        $this->resetAfterTest();

        $shortname = 'mnetprofile';

        $categoryid = \tool_powereducnet\profile_manager::create_user_profile_category();
        \tool_powereducnet\profile_manager::create_user_profile_text_field($categoryid);

        $record = $DB->get_record('user_info_field', ['shortname' => $shortname]);
        $this->assertEquals($shortname, $record->shortname);
        $this->assertEquals($categoryid, $record->categoryid);

        // Test for a unique name if 'mnetprofile' is already in use.
        \tool_powereducnet\profile_manager::create_user_profile_text_field($categoryid);
        $profilename = \tool_powereducnet\profile_manager::get_profile_field_name();
        $this->assertEquals($shortname . 1, $profilename);
        \tool_powereducnet\profile_manager::create_user_profile_text_field($categoryid);
        $profilename = \tool_powereducnet\profile_manager::get_profile_field_name();
        $this->assertEquals($shortname . 2, $profilename);
    }

    /**
     * Test that the user powereducnet profile is saved.
     */
    public function test_save_powereducnet_user_profile() {
        $this->resetAfterTest();

        $user = $this->getDataGenerator()->create_user();
        $profilename = '@matt@hq.mnet';

        $powereducnetprofile = new \tool_powereducnet\powereducnet_user_profile($profilename, $user->id);

        \tool_powereducnet\profile_manager::save_powereducnet_user_profile($powereducnetprofile);

        $userdata = \core_user::get_user($user->id);
        $this->assertEquals($profilename, $userdata->powereducnetprofile);
    }
}
