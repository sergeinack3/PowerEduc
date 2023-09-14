<?php
// This file is part of PowerEduc Course Rollover Plugin
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

/**
 * @package     local_powerschool
 * @author      Wilfried
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core\progress\display;
// use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/listeetuabsenetu.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('absenceetu', 'local_powerschool'));
$PAGE->set_heading(get_string('absenceetu', 'local_powerschool'));

// $PAGE->navbar->add(get_string('statistique', 'local_powerschool'),  new powereduc_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('absenceetu', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();


// $inscription =$tab = array();

//absence

$sql="SELECT sbet.id,firstname,lastname,a.datedebut,a.datefin,sbet.idprof,fullname,sbet.timecreated
FROM {absenceetu} sbet,{user} u,{anneescolaire} a,{course} c,{coursspecialite} cs,{courssemestre} css,{cycle} cy,{specialite} sp
WHERE u.id=sbet.idetudiant AND c.id=sbet.idcourses AND a.id=sbet.idanneescolaire AND sbet.idspecialite=sp.id AND sbet.idetudiant='".$USER->id."'
AND sbet.idcycle=cy.id AND cs.idcourses=c.id AND cs.id=css.idcoursspecialite AND css.idsemestre='".$_GET["idsem"]."'";
$cours=$DB->get_records_sql($sql);

foreach ($cours as $key => $value1) {
    $user=$DB->get_records("user",array("id"=>$value1->idprof));
    foreach($user as $key => $vauser)
    {}
    $value1->timecreated=date("d-m-Y",$value1->timecreated);
// var_dump($vauser->fullname,$value1->idprof);die;
    $value1->professeur=$vauser->firstname;
    $value1->dateannee=date("Y",$value1->datedebut).'-'.date("Y",$value1->datefin);

}
//filiere
$semestre=$DB->get_records("semestre");
$templatecontext = (object)[
    'semestre'=>array_values($semestre),
    // // 'campus'=>array_values($campus),
    'cours'=>array_values($cours),
    // 'annee'=>array_values($annee),
    'absence'=> new powereduc_url('/local/powerschool/absenceetu.php'),
    'courssemestre'=> new powereduc_url('/local/powerschool/listeetuabsenetu.php'),
    // 'affectercours'=> new powereduc_url('/local/powerschool/inscription.php'),
    // 'ajou'=> new powereduc_url('/local/powerschool/classes/entrernote.php'),
    // 'coursid'=> new powereduc_url('/local/powerschool/entrernote.php'),
    // 'bulletinnote'=> new powereduc_url('/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'idca'=>$_GET["idca"],
    // 'salleele' => new powereduc_url('/local/powerschool/salleele.php'),
    'salleeleretirer' => new powereduc_url('/local/powerschool/absenceetu.php'),

 ];

//  $menumini = (object)[
//     'affecterprof' => new powereduc_url('/local/powerschool/affecterprof.php'),
//     'configurerpaie' => new powereduc_url('/local/powerschool/configurerpaiement.php'),
//     'coursspecialite' => new powereduc_url('/local/powerschool/coursspecialite.php'),
//     'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
//     'salleele' => new powereduc_url('/local/powerschool/salleele.php'),
// ];

// $menu = (object)[
//     'annee' => new powereduc_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new powereduc_url('/local/powerschool/campus.php'),
//     'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
//     'salle' => new powereduc_url('/local/powerschool/salle.php'),
//     'seance' => new powereduc_url('/local/powerschool/seance.php'),
//     'filiere' => new powereduc_url('/local/powerschool/filiere.php'),
//     'cycle' => new powereduc_url('/local/powerschool/cycle.php'),
//     'modepayement' => new powereduc_url('/local/powerschool/modepayement.php'),
//     'matiere' => new powereduc_url('/local/powerschool/matiere.php'),
//     'specialite' => new powereduc_url('/local/powerschool/specialite.php'),
//     'inscription' => new powereduc_url('/local/powerschool/inscription.php'),
//     'enseigner' => new powereduc_url('/local/powerschool/enseigner.php'),
//     'paiement' => new powereduc_url('/local/powerschool/paiement.php'),
//     'programme' => new powereduc_url('/local/powerschool/programme.php'),
//     'notes' => new powereduc_url('/local/powerschool/note.php'),

// ];

// $campus=$DB->get_records('campus');
$campuss=(object)[
        // 'campus'=>array_values($campus),
        'confpaie'=>new powereduc_url('/local/powerschool/listeetuabsenprof.php'),
    ];
echo $OUTPUT->header();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo '<div style="margin-top:80px";><wxcvbn</div>';
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/listeetuabsenetu', $templatecontext);


echo $OUTPUT->footer();