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
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/inscription.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Configuration Bulletin');
$PAGE->set_heading('Configuration Bulletin');

// $PAGE->navbar->add('Administration du Site',  new powereduc_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new note();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data() ) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;
    
// var_dump($recordtoinsert);
// die;
    # code...
    $recordtoinsert->idcycle=$fromform->idcycle;
    $recordtoinsert->idprofesseur=$USER->id;
    $recordtoinsert->idcampus=$fromform->idcampus;
    $recordtoinsert->idsemestre=$fromform->idsemestre;
    $recordtoinsert->idanneescolaire=$fromform->idanneescolaire;
    $recordtoinsert->idspecialite=$fromform->idspecialite;
    $recordtoinsert->usermodified=$fromform->usermodified;
    $recordtoinsert->timecreated=$fromform->timecreated;
    $recordtoinsert->timemodified=$fromform->timemodified;

    // var_dump($recordtoinsert);die;
    // $DB->insert_record('bulletin', $recordtoinsert);
    $DB->execute("INSERT INTO mdl_bulletin VALUES(0,'".$USER->id."','".$recordtoinsert->idanneescolaire."','".$recordtoinsert->idsemestre."','".$recordtoinsert->idcampus."','".$recordtoinsert->idspecialite."','".$recordtoinsert->idcycle."','".$recordtoinsert->usermodified."','".$recordtoinsert->timecreated."','".$recordtoinsert->timemodified."')");
    redirect($CFG->wwwroot . '/local/powerschool/note.php', 'Enregistrement effectué');


 
   
}



// if($_GET['id']) {

//     // $mform->supp_inscription($_GET['id']);
//     redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Information Bien supprimée');
        
// }


// $inscription =$tab = array();

$sql_inscrip = "SELECT i.id as idbu,idspecialite,idcycle,i.idanneescolaire,i.idcampus,idsemestre,libellesemestre,datedebut,datefin,villecampus,libellecampus,libellespecialite,libellecycle,nombreannee
                FROM {bulletin} i, {anneescolaire} a,{semestre} sem, {user} u, {specialite} s, {campus} c, {cycle} cy
                WHERE i.idanneescolaire=a.id AND i.idspecialite=s.id AND i.idprofesseur=u.id 
                AND i.idcampus=c.id AND i.idcycle = cy.id AND i.idsemestre=sem.id AND i.idprofesseur='".$USER->id."'" ;

// $inscription = $DB->get_records('inscription', null, 'id');


// var_dump($sql_inscrip);
// die;
$inscriptionss = $DB->get_recordset_sql($sql_inscrip);
// $i=0;

// var_dump($inscription);
// die;

$inscription=array();
foreach ($inscriptionss as $key=> $value){

    $time = $value->datedebut;
    $timef = $value->datefin;

    $dated = date('Y',$time);
    $datef = date('Y',$timef);

    $value->datedebut = $dated;
    $value->datefin = $datef;

    $inscription[]= (array) $value;

}

// var_dump($i);
// var_dump($inscription);
// die;

$templatecontext = (object)[
    'inscription' => array_values($inscription),
    // 'nb'=>array_values($tab),
    'inscriptionedit' => new powereduc_url('/local/powerschool/inscriptionedit.php'),
    'inscriptionsupp'=> new powereduc_url('/local/powerschool/inscription.php'),
    'note'=> new powereduc_url('/local/powerschool/entrernote.php'),
    // 'imprimer' => new powereduc_url('/local/powerschool/imp.php'),
];

$menu = (object)[
    'annee' => new powereduc_url('/local/powerschool/anneescolaire.php'),
    'campus' => new powereduc_url('/local/powerschool/campus.php'),
    'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
    'salle' => new powereduc_url('/local/powerschool/salle.php'),
    'seance' => new powereduc_url('/local/powerschool/seance.php'),
    'filiere' => new powereduc_url('/local/powerschool/filiere.php'),
    'cycle' => new powereduc_url('/local/powerschool/cycle.php'),
    'modepayement' => new powereduc_url('/local/powerschool/modepayement.php'),
    'matiere' => new powereduc_url('/local/powerschool/matiere.php'),
    'specialite' => new powereduc_url('/local/powerschool/specialite.php'),
    'inscription' => new powereduc_url('/local/powerschool/inscription.php'),
    'enseigner' => new powereduc_url('/local/powerschool/enseigner.php'),
    'paiement' => new powereduc_url('/local/powerschool/paiement.php'),
    'programme' => new powereduc_url('/local/powerschool/programme.php'),
    'notes' => new powereduc_url('/local/powerschool/note.php'),

];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/note', $templatecontext);


echo $OUTPUT->footer();