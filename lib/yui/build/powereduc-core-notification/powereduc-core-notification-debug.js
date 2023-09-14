YUI.add('powereduc-core-notification', function (Y, NAME) {

/**
 * The notification module provides a standard set of dialogues for use
 * within PowerEduc.
 *
 * @module powereduc-core-notification
 * @main
 */

/**
 * To avoid bringing powereduc-core-notification into modules in it's
 * entirety, we now recommend using on of the subclasses of
 * powereduc-core-notification. These include:
 * <dl>
 *  <dt> powereduc-core-notification-dialogue</dt>
 *  <dt> powereduc-core-notification-alert</dt>
 *  <dt> powereduc-core-notification-confirm</dt>
 *  <dt> powereduc-core-notification-exception</dt>
 *  <dt> powereduc-core-notification-ajaxexception</dt>
 * </dl>
 *
 * @class M.core.notification
 * @deprecated
 */
Y.log("The powereduc-core-notification parent module has been deprecated. " +
        "Please use one of its subclasses instead.", 'powereduc-core-notification', 'warn');


}, '@VERSION@', {
    "requires": [
        "powereduc-core-notification-dialogue",
        "powereduc-core-notification-alert",
        "powereduc-core-notification-confirm",
        "powereduc-core-notification-exception",
        "powereduc-core-notification-ajaxexception"
    ]
});
