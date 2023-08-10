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
use local_powerschool\anneescolaire;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/anneescolaire.php');

global $DB;

require_login();
$context = context_system::instance();
require_capability('local/powerschool:managepages', $context);

// $PAGE->set_url(new moodle_url('/local/powerschool/anneescolaireedit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Modifier une Année Scolaire');
$PAGE->set_heading('Modifier une Année Scolaire');
$PAGE->navbar->add(get_string('Annee_edit', 'local_powerschool'), $managementurl);


$id = optional_param('id',null,PARAM_INT);

$mform=new anneescolaire();


if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/anneescolaire/anneescolaire.php', 'annuler');

} else if ($fromform = $mform->get_data()) {

$recordtoinsert = new anneescolaire();

    if($fromform->id) {

        $recordtoinsert->update_annee($fromform->id, $fromform->datedebut, $fromform->datefin);
        redirect($CFG->wwwroot . '/local/powerschool/anneescolaire/anneescolaire.php', 'Bien modifier');

    // $recordtoinsert = $fromform;
    // var_dump($recordtoinsert,$_GET['id']);
    // die;

    // var_dump($_GET['id'], $fromform->datedebut, $fromform->datefin);
    // die;

        // $mform->update_annee($fromform->id, $fromform->datedebut, $fromform->datefin);
        // redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien modifier');

            
    }

}

if ($id) {
    // Add extra data to the form.
    global $DB;
    $anneescolaire = new anneescolaire();
    $annee = $anneescolaire->get_annee($id);
    if (!$annee) {
        throw new invalid_parameter_exception('Message not found');
    }
    $mform->set_data($annee);
}



echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();



// if ($fromform->id) {

//     $mform->update_annee($fromform->id, $fromform->datedebut, $fromform->dstefin);
//     redirect($CFG->wwwroot . '/local/powerschool/anneescolaire.php', 'Bien modifier');
    
   
// }