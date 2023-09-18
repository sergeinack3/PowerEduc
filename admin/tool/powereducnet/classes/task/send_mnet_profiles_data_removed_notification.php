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

declare(strict_types=1);

namespace tool_powereducnet\task;

use core\message\message;

/**
 * Ad-hoc task to send a notification to admin stating that the user data related to the linked PowerEducNet profiles has
 * been removed.
 *
 * @package   tool_powereducnet
 * @copyright 2022 Mihail Geshoski <mihail@powereduc.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class send_mnet_profiles_data_removed_notification extends \core\task\adhoc_task {
    public function execute(): void {
        $message = new message();
        $message->component = 'powereduc';
        $message->name = 'notices';
        $message->userfrom = \core_user::get_noreply_user();
        $message->userto = get_admin();
        $message->notification = 1;
        $message->subject = get_string('removedmnetprofilenotification_subject', 'tool_powereducnet');
        $message->fullmessageformat = FORMAT_HTML;
        $message->fullmessagehtml = get_string('removedmnetprofilenotification', 'tool_powereducnet');
        $message->smallmessage = strip_tags($message->fullmessagehtml);
        message_send($message);
    }
}
