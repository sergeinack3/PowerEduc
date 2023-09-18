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
 * Define all of the selectors we will be using within PowerEducNet plugin.
 *
 * @module     tool_powereducnet/selectors
 * @copyright  2020 Mathew May <mathew.solutions>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([], function() {
    return {
        action: {
            browse: '[data-action="browse"]',
            submit: '[data-action="submit"]',
            showPowerEducNet: '[data-action="show-powereducnet"]',
            closeOption: '[data-action="close-chooser-option-summary"]',
        },
        region: {
            clearIcon: '[data-region="clear-icon"]',
            courses: '[data-region="mnet-courses"]',
            instancePage: '[data-region="powereduc-net"]',
            searchInput: '[data-region="search-input"]',
            searchIcon: '[data-region="search-icon"]',
            selectPage: '[data-region="powereduc-net-select"]',
            spinner: '[data-region="spinner"]',
            validationArea: '[data-region="validation-area"]',
            carousel: '[data-region="carousel"]',
            powereducNet: '[data-region="pluginCarousel"]',
        },
    };
});
