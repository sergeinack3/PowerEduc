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
 * A javascript module to handle question ajax actions.
 *
 * @deprecated since PowerEduc 4.0
 * @todo Final deprecation on PowerEduc 4.4 MDL-72438
 * @module     core_question/repository
 * @copyright  2017 Simey Lameze <lameze@powereduc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery', 'core/ajax'], function($, Ajax) {

    /**
     * Submit the form data for the question tags form.
     *
     * @method submitTagCreateUpdateForm
     * @param  {number} questionId
     * @param  {number} contextId
     * @param {string} formdata The URL encoded values from the form
     * @returns {promise}
     */
    var submitTagCreateUpdateForm = function(questionId, contextId, formdata) {
        window.console.warn('warn: The core_question/repository has been deprecated.' +
            'Please use qbank_tagquestion/repository instead.');
        var request = {
            methodname: 'core_question_submit_tags_form',
            args: {
                questionid: questionId,
                contextid: contextId,
                formdata: formdata
            }
        };

        return Ajax.call([request])[0];
    };

    return {
        submitTagCreateUpdateForm: submitTagCreateUpdateForm
    };
});
