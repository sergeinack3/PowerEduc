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
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/rentrernote.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Entrer les '.$_GET['libelcou'].'');
$PAGE->set_heading('Vos Notes ');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();









// $inscription =$tab = array();

$sql="SELECT * FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{courssemestre} cse
                WHERE af.id=li.idaffecterprof AND cse.id=af.idcourssemestre AND cse.idcoursspecialite=co.id AND co.idcourses=scou.id AND li.idetudiant='".$USER->id."'";
  $notes=$DB->get_records_sql($sql);
//   var_dump($notes);die;
$templatecontext = (object)[
    'notes'=>array_values($notes),
    'ajoute'=> new moodle_url('/local/powerschool/inscription.php'),
    'affectercours'=> new moodle_url('/local/powerschool/inscription.php'),
    'ajou'=> new moodle_url('/local/powerschool/classes/entrernote.php'),
    'coursid'=> new moodle_url('/local/powerschool/entrernote.php'),
    'bulletinnote'=> new moodle_url('/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'tirerbulletin'=>new moodle_url('/local/powerschool/recu/facture/bulletin.php'),
    'idetu'=>$_GET["idet"]
 ];

// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'specialite' => new moodle_url('/local/powerschool/specialite.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     'notes' => new moodle_url('/local/powerschool/note.php'),

// ];

$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'paiement' => new moodle_url('/local/powerschool/paiementperso.php'),
    'note' => new moodle_url('/local/powerschool/bulletinnoteperso.php'),

];


echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbargerer', $menu);
// $mform->display();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/bulletinnoteperso', $templatecontext);


echo $OUTPUT->footer();