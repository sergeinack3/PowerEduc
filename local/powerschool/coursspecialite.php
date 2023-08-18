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
use local_powerschool\coursspecialite;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/coursspecialite.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/coursspecialite.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('coursspecialite', 'local_powerschool'));
$PAGE->set_heading(get_string('coursspecialite', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('coursspecialite', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new coursspecialite();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


    $recordtoinsert = new stdClass();
    
    $recordtoinsert = $fromform;
    
        // var_dump($fromform);
        // die;
    
        if (!$mform->verifcourspeciali($recordtoinsert->idcourses, $recordtoinsert->idcycle,$_POST["idspecialite"])) {
            # code...

            // var_dump($recordtoinsert->idcourses, $_POST["idcycle"],$_POST["idspecialite"],$_POST["credit"]);die;
            $recordtoinsert->idcycle=$_POST["idcycle"];
            $recordtoinsert->idspecialite=$_POST["idspecialite"];
            $recordtoinsert->credit=$_POST["credit"];
            $DB->insert_record('coursspecialite', $recordtoinsert);
            // $DB->execute("INSERT INTO mdl_coursspecialite VALUES(0,'".$recordtoinsert->idcourses."','".$recordtoinsert->idspecialite."','".$recordtoinsert->idcycle."','".$recordtoinsert->credit."','".$recordtoinsert->usermodified."','".$recordtoinsert->timecreated."','".$recordtoinsert->timemodified."')");
            redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
            exit;
        }else{
            \core\notification::add('Ce cours a été déjà affecté à cette specialité de ce cycle', \core\output\notification::NOTIFY_ERROR);

            // redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php', 'Ce cours a été déjà affecté à cette specialité de ce cycle');
        }
     
    }

if($_GET['id']) {

    $mform->supp_coursspecialite($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/coursspecialite.php', 'Information Bien supprimée');
        
}


$sql = "SELECT cs.id,fullname,libellespecialite,libellecycle,credit,shortname,abreviationspecialite,cy.nombreannee FROM {course} c, {specialite} s, {cycle} cy,{coursspecialite} cs,{filiere} f
        WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND cs.idcourses = c.id AND f.idcampus='".$_GET["idca"]."'";

// $sql = "SELECT cs.id,fullname,libellespecialite,libellecycle,credit,shortname,abreviationspecialite,nombreannee FROM {course} c, {specialite} s, {cycle} cy , {coursspecialite} cs,{filiere} f
//         WHERE s.idfiliere=f.id AND cs.idcycle = cy.id AND cs.idspecialite = s.id AND cs.idcourses = c.id AND idcampus='".$_GET["idca"]."'";


// $coursspecialite = $DB->get_records('coursspecialite', null, 'id');

// $tarcoursspecialite=array();
$coursspecialites = $DB->get_recordset_sql($sql);
foreach ($coursspecialites as $key => $value) {
       $tarcoursspecialite[]=(array)$value;
}
// var_dump($tarcoursspecialite);die;
if(empty($tarcoursspecialite))
{
    $tarcoursspecialite[]="select";
}
$templatecontext = (object)[
    'coursspecialite' => array_values($tarcoursspecialite),
    'coursspecialiteedit' => new moodle_url('/local/powerschool/coursspecialiteedit.php'),
    'coursspecialitesupp'=> new moodle_url('/local/powerschool/coursspecialite.php'),
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'affectersemes' => new moodle_url('/local/powerschool/courssemestre.php'),
    'idca'=>$_GET["idca"]
];

// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'notes' => new moodle_url('/local/powerschool/note.php'),

// ];

$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'confinot' => new moodle_url('/local/powerschool/configurationnote.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),


];
$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/coursspecialite.php'),
    ];
echo $OUTPUT->header();

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/coursspecialite', $templatecontext);


echo $OUTPUT->footer();