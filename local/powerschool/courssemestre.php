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
use local_powerschool\courssemestre;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/courssemestre.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/courssemestre.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un cours par semestre');
$PAGE->set_heading('Enregistrer un cours par semestre');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('courssemestre', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new courssemestre();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 
        $DB->insert_record('courssemestre', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/courssemestre.php?idcosp='.$_POST["idcoursspecialite"].'', 'Enregistrement effectué');
        exit;
}

if($_GET['id']) {

    $mform->supp_courssemestre($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/courssemestre.php?idcosp='.$_GET["idcosp"].'', 'Information Bien supprimée');
        
}


$sql = "SELECT cs.id as idcose,libellesemestre,nombreheure,idcoursspecialite as idcosp FROM  {semestre} s, {courssemestre} cs WHERE cs.idsemestre = s.id AND cs.idcoursspecialite = '".$_GET["idcosp"]."' ";


$courssemestres = $DB->get_records_sql($sql);

// var_dump($courssemestres);
// die;
// $courssemestre = $DB->get_records('courssemestre', null, 'id');

$templatecontext = (object)[
    'courssemestre' => array_values($courssemestres),
    'courssemestreedit' => new moodle_url('/local/powerschool/courssemestreedit.php'),
    'courssemestresupp'=> new moodle_url('/local/powerschool/courssemestre.php'),
    'affecter' => new moodle_url('/local/powerschool/affecter.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),

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
    'notes' => new moodle_url('/local/powerschool/note.php'),

];


echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/courssemestre', $templatecontext);


echo $OUTPUT->footer();