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
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/affecterprof.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Configuration Minimal');
$PAGE->set_heading('Configuration Minimal');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('affecterprof', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new affecterprof();


if ($fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 
        $DB->insert_record('affecterprof', $recordtoinsert);
}

//elle permet faire une affectation d'un professeur à une matiere dans une specialite et un cycle precis
if (!empty($_POST["professeur"])&& !empty($_POST["specialite"])&& !empty($_POST["cycle"])&& !empty($_POST["cours"]) && !empty($_POST["semestre"])) {
//  var_dump("df");die;
     $cours=$DB->get_records_sql("SELECT cse.id as idcouse FROM {coursspecialite} as csp,{courssemestre} cse WHERE csp.id=cse.idcoursspecialite AND idsemestre='".$_POST["semestre"]."' AND idcourses='".$_POST["cours"]."' AND idspecialite='".$_POST["specialite"]."' AND idcycle='".$_POST["cycle"]."'");
     foreach ($cours as $key => $value) {
         
    }
    $recordtoinsert = new stdClass();
    $recordtoinsert->idcourssemestre = $value->idcouse;
    // var_dump($recordtoinsert->idcourssemestre);die;
     $recordtoinsert->idprof =$_POST["professeur"];
    //  var_dump($_POST["professeur"],$_POST["specialite"],$_POST["cycle"],$_POST["cours"],$_POST["semestre"],$recordtoinsert->idcourssemestre,$recordtoinsert->idprof,$USER->id);die;
     $DB->execute("INSERT INTO mdl_affecterprof VALUES (0,'".$recordtoinsert->idcourssemestre."', '".$recordtoinsert->idprof."', '".$USER->id."','".time()."','".time()."')");
    //  $DB->insert_record('affecterprof', $recordtoinsert);
}

if($_GET['id']) {

    // var_dump($_GET["id"]);die;
    $mform->supp_affecterprof($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/affecterprof.php', 'Bien supp');
        
}

//professeur
$sql="SELECT us.id as userid,firstname,lastname FROM {user} as us,{role_assignments} WHERE us.id=userid AND roleid=3";
$professeur=$DB->get_records_sql($sql);
//specialite
$sql="SELECT sp.id,libellespecialite FROM {specialite} sp,{filiere} f WHERE sp.idfiliere=f.id AND idcampus='".$_GET["idca"]."'";
$specialite=$DB->get_records_sql($sql);

$affecter=$DB->get_recordset_sql("SELECT af.id as idaffe,libellecycle,libellespecialite,libellesemestre,fullname,firstname,lastname FROM {coursspecialite} as csp,{courssemestre} cse,{affecterprof} af,
                            {semestre} se,{specialite} sp,{cycle} cy,{course} cou,{user} as us,{filiere} f WHERE sp.idfiliere=f.id AND csp.id=cse.idcoursspecialite AND us.id=idprof
                            AND idsemestre=se.id AND idcourses=cou.id AND idspecialite=sp.id AND idcycle=cy.id AND af.idcourssemestre=cse.id AND f.idcampus='".$_GET["idca"]."'");
// $affecterprof = $DB->get_recordset_sql('affecterprof', null, 'id');
$affecterprof = array();
foreach ($affecter as $record) {
    $affecterprof[] = (array) $record;
}
$templatecontext = (object)[
    'affecterprof' => array_values($affecterprof),
    'professeur' => array_values($professeur),
    'specialite' => array_values($specialite),
    'affecterprofedit' => new moodle_url('/local/powerschool/affecterprofedit.php'),
    'affecterprofsupp'=> new moodle_url('/local/powerschool/affecterprof.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'courssemestre' => new moodle_url('/local/powerschool/affecterprof.php'),
    'root'=>$CFG->wwwroot
];

$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),

    ];
$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/affecterprof.php'),
    ];
// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
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
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     'notes' => new moodle_url('/local/powerschool/note.php'),
// ];


echo $OUTPUT->header();

echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/affecterprof', $templatecontext);


echo $OUTPUT->footer();