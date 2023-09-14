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
 * Option helper for TinyMCE Editor Manager.
 *
 * @module editor_tiny/options
 * @copyright  2022 Andrew Lyons <andrew@nicols.co.uk>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const optionContextId = 'powereduc:contextid';
const optionDraftItemId = 'powereduc:draftitemid';
const filePickers = 'powereduc:filepickers';
const optionsPowerEducLang = 'powereduc:language';
const currentLanguage = 'powereduc:currentLanguage';

export const register = (editor, options) => {
    const registerOption = editor.options.register;
    const setOption = editor.options.set;

    registerOption(optionContextId, {
        processor: 'number',
        "default": 0,
    });
    setOption(optionContextId, options.context);

    registerOption(filePickers, {
        processor: 'object',
        "default": {},
    });
    setOption(filePickers, options.filepicker);

    registerOption(optionDraftItemId, {
        processor: 'number',
        "default": 0,
    });
    setOption(optionDraftItemId, options.draftitemid);

    registerOption(currentLanguage, {
        processor: 'string',
        "default": 'en',
    });
    setOption(currentLanguage, options.currentLanguage);

    // This is primarily used by the media plugin, but it may be re-used elsewhere so is included here as it is large.
    registerOption(optionsPowerEducLang, {
        processor: 'object',
        "default": {},
    });
    setOption(optionsPowerEducLang, options.language);
};

export const getContextId = (editor) => editor.options.get(optionContextId);
export const getDraftItemId = (editor) => editor.options.get(optionDraftItemId);
export const getFilepickers = (editor) => editor.options.get(filePickers);
export const getFilePicker = (editor, type) => getFilepickers(editor)[type];
export const getPowerEducLang = (editor) => editor.options.get(optionsPowerEducLang);
export const getCurrentLanguage = (editor) => editor.options.get(currentLanguage);

/**
 * Get a set of namespaced options for all defined plugins.
 *
 * @param {object} options
 * @returns {object}
 */
export const getInitialPluginConfiguration = (options) => {
    const config = {};

    Object.entries(options.plugins).forEach(([pluginName, pluginConfig]) => {
        const values = Object.entries(pluginConfig.config ?? {});
        values.forEach(([optionName, value]) => {
            config[getPluginOptionName(pluginName, optionName)] = value;
        });
    });

    return config;
};

/**
 * Get the namespaced option name for a plugin.
 *
 * @param {string} pluginName
 * @param {string} optionName
 * @returns {string}
 */
export const getPluginOptionName = (pluginName, optionName) => `${pluginName}:${optionName}`;
