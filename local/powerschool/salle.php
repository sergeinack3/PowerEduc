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
use local_powerschool\salle;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/salle.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/salle.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une salle');
$PAGE->set_heading('Enregistrer une salle');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('Salle', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new salle();


// $specialiteprimary=[
//    $libelle=> "Sil",
//    $libelle=>"CP",
//    $libelle=> "CE1",
//    $libelle=> "CE2",
//    $libelle=> "CM1",
//    $libelle=>"CM2",
// ];

if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


    $recordtoinsert = new stdClass();
    
    $recordtoinsert = $fromform;
    
        // var_dump($fromform);
        // die;
    
        if (!$mform->veriSalle($recordtoinsert->numerosalle,$recordtoinsert->idcampus)) {
            $DB->insert_record('salle', $recordtoinsert);
            redirect($CFG->wwwroot . '/local/powerschool/salle.php', 'Enregistrement effectué');
            exit;
        }else{
            // redirect($CFG->wwwroot . '/local/powerschool/salle.php', 'Cette salle execite dans ce campus');
            \core\notification::add('Cette salle existe dans ce campus', \core\output\notification::NOTIFY_ERROR);

        }
     
    }

if($_GET['id']) {

    $mform->supp_salle($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/salle.php', 'Information Bien supprimée');
        
}


$sql = "SELECT * FROM {campus} c, {salle} s WHERE s.idcampus = c.id ";


// $salle = $DB->get_records('salle', null, 'id');

$salles = $DB->get_records_sql($sql);


// var_dump($salles);
// die;

$templatecontext = (object)[
    'salle' => array_values($salles),
    // 'specialiteprimary' => array_values($specialiteprimary),
    'salleedit' => new moodle_url('/local/powerschool/salleedit.php'),
    'sallesupp'=> new moodle_url('/local/powerschool/salle.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
];

$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'campus' => new moodle_url('/local/powerschool/campus.php'),
    'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
    'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
    'gerer' => new moodle_url('/local/powerschool/gerer.php'),
    'modepaie' => new moodle_url('/local/powerschool/modepaiement.php'),
    'statistique' => new moodle_url('/local/powerschool/statistique.php'),


];


echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/salle', $templatecontext);


echo $OUTPUT->footer();