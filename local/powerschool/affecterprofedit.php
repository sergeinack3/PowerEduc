<?php
// This file is part of Moodle Course Rollover Plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
use local_powerschool\affecterprof;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/affecterprof.php');

global $DB;

require_login();
$context = context_system::instance();
require_capability('local/powerschool:managepages', $context);

// $PAGE->set_url(new moodle_url('/local/powerschool/anneescolaireedit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Modifier un affecterprof');
$PAGE->set_heading('Modifier un affecterprof');


$id = optional_param('id',null,PARAM_INT);

$mform=new affecterprof();


if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/affecterprof.php', 'annuler');

} else if ($fromform = $mform->get_data()) {

$recordtoinsert = new affecterprof();

    if($fromform->id) {

        $recordtoinsert->update_affecterprof($fromform->id, $fromform->idcoursspecialite, $fromform->idprof);
        redirect($CFG->wwwroot . '/local/powerschool/affecterprof.php', 'Bien modifier');
        
    }

}

if ($id) {
    // Add extra data to the form.
    global $DB;
    $newaffecterprof = new affecterprof();
    $affecterprof = $newaffecterprof->get_affecterprof($id);
    if (!$affecterprof) {
        throw new invalid_parameter_exception('Message not found');
    }
    $mform->set_data($affecterprof);
}



echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();



// if ($fromform->id) {

//     $mform->update_annee($fromform->id, $fromform->datedebut, $fromform->dstefin);
//     redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien modifier');
    
   
// }