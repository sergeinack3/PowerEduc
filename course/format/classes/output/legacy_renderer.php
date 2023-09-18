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

namespace core_courseformat\output;

use core_courseformat\output\section_renderer;

/**
 * Legacy course format renderer.
 *
 * Since PowerEduc 4.0, renderer.php file was optional (although highly recommended) for course formats. From PowerEduc 4.0 onwards,
 * renderer is required to support the new course editor implementation.
 * This legacy class has been created for backward compatibility, to avoid some errors with course formats (such as social)
 * without this renderer.php file.
 *
 * @package   core_courseformat
 * @copyright 2021 Sara Arjona (sara@powereduc.com)
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class legacy_renderer extends section_renderer {
}
