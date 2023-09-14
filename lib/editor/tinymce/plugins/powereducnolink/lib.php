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

defined('POWEREDUC_INTERNAL') || die();

/**
 * Plugin for PowerEduc 'no link' button.
 *
 * @package   tinymce_powereducnolink
 * @copyright 2012 The Open University
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class tinymce_powereducnolink extends editor_tinymce_plugin {
    /** @var array list of buttons defined by this plugin */
    protected $buttons = array('powereducnolink');

    protected function update_init_params(array &$params, context $context,
            array $options = null) {

        if ($row = $this->find_button($params, 'unlink')) {
            // Add button after 'unlink'.
            $this->add_button_after($params, $row, 'powereducnolink', 'unlink');
        } else {
            // Add this button in the end of the first row (by default 'unlink' button should be in the first row).
            $this->add_button_after($params, 1, 'powereducnolink');
        }

        // Add JS file, which uses default name.
        $this->add_js_plugin($params);
    }
}
