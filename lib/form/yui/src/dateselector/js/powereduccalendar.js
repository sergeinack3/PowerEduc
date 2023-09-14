/**
 * Provides the PowerEduc Calendar class.
 *
 * @module powereduc-form-dateselector
 */

/**
 * A class to overwrite the YUI3 Calendar in order to change the strings..
 *
 * @class M.form_powereduccalendar
 * @constructor
 * @extends Calendar
 */
POWEREDUCCALENDAR = function() {
    POWEREDUCCALENDAR.superclass.constructor.apply(this, arguments);
};

Y.extend(POWEREDUCCALENDAR, Y.Calendar, {
        initializer: function(cfg) {
            this.set("strings.very_short_weekdays", cfg.WEEKDAYS_MEDIUM);
            this.set("strings.first_weekday", cfg.firstdayofweek);
        }
    }, {
        NAME: 'Calendar',
        ATTRS: {}
    }
);

M.form_powereduccalendar = M.form_powereduccalendar || {};
M.form_powereduccalendar.initializer = function(params) {
    return new POWEREDUCCALENDAR(params);
};
