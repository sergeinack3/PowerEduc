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
use local_powerschool\inscription;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/inscription.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/inscription.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('inscription de Cours');
$PAGE->set_heading('inscription de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new inscription();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data() ) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;
    
// var_dump($recordtoinsert);
// die;
if (!$mform->veri_insc($recordtoinsert->idetudiant)) {
    # code...
    $recordtoinsert->idcycle=$fromform->idcycle;
    $recordtoinsert->idcampus=$fromform->idcampus;
    $recordtoinsert->idetudiant=$fromform->idetudiant;
    $recordtoinsert->cycle=$fromform->cycle;
    $recordtoinsert->nomsparent=$fromform->nomsparent;
    $recordtoinsert->telparent=$fromform->telparent;
    $recordtoinsert->emailparent=$fromform->emailparent;
    $recordtoinsert->professionparent=$fromform->professionparent;
    $recordtoinsert->usermodified=$fromform->usermodified;
    $recordtoinsert->timecreated=$fromform->timecreated;
    $recordtoinsert->timemodified=$fromform->timemodified;

    // var_dump($recordtoinsert);die;
    $DB->insert_record('inscription', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Enregistrement effectué');
    exit;
}else{
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Cet etudiant est déjà inscript');

}


   


 
   
}


if($_GET['id'] && $_GET['action']='affectercours') {


    $getid = $_GET['id'];

    $sql_get_inscrip = "SELECT idetudiant FROM {inscription} WHERE id = $getid " ;

    $req = $DB->get_records_sql($sql_get_inscrip);
    
    foreach ($req as $key=>$val){
        $idetudiant = $key;
    } 
    
    
    //Affectation des cours de la specialite a l'etudiant
    
    $sql_cours = "SELECT c.id, c.fullname, e.id as enroleid, e.enrol,i.idspecialite,i.idcycle FROM {inscription} i, {user} u, {specialite} s, {coursspecialite} cs, {course} c, {enrol} e 
    WHERE i.idetudiant=u.id AND i.idspecialite=s.id AND cs.idspecialite=s.id AND cs.idcourses=c.id AND e.courseid = c.id AND e.enrol='manual' AND i.idetudiant = $idetudiant";


// var_dump($sql_get_inscrip);
// var_dump($req);
// var_dump($sql_cours);

// die;

$recuperer_cours=array();

$recuperer_cours = $DB->get_records_sql($sql_cours);

// var_dump(  $recuperer_cours );
// die;

foreach ($recuperer_cours as $key=>$val){
    
    $sql_verienr="SELECT * FROM {user_enrolments} WHERE enrolid='".$val->enroleid."' AND userid='".$idetudiant."'";
    $verif=$DB->get_records_sql($sql_verienr);
    // var_dump($verif);die;
  if (!$verif) {
    # code...
  
    $sql_enrol = "INSERT INTO {user_enrolments} (`status`, `enrolid`, `userid`, `timestart`, `timeend`, `modifierid`, `timecreated`, `timemodified`) 
                VALUES ('0',$val->enroleid,$idetudiant,'0','0',$USER->id,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    $sql_enrol = [
    
        "status"=>0,
        "enrolid"=> $val->enroleid,
        "userid"=>$idetudiant,
        "timestart"=>0,
        "timeend"=>0,
        "modifierid"=>$USER->id,
        "timecreated"=>time(),
        "timemodified"=>time()];
        // var_dump($recuperer_cours);die;
        
        // var_dump($sql_enrol);
        // die;
        
        $DB->insert_record('user_enrolments', $sql_enrol);
        
    
            
      }


    }
             
    $sql="SELECT * FROM {coursspecialite} WHERE idspecialite='".$val->idspecialite."' AND idcycle='".$val->idcycle."'";
    $listenote=$DB->get_records_sql($sql);
    foreach ($listenote as $key => $value) {
        $sql1="SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$value->id."'";
        $listenote1=$DB->get_records_sql($sql1);
        
        foreach ($listenote1 as $key => $value1) {
            # code...
            $sql2="SELECT * FROM {affecterprof} c WHERE c.idcourssemestre='".$value1->id."'";
            $listenote2=$DB->get_records_sql($sql2);
            // var_dump($listenote2);
            // var_dump($listenote1);die;
            foreach ($listenote2 as $key => $value2) {
                // var_dump($value1->id,$idetudiant);
                
                $notet=new stdClass();
                $notet->idaffecterprof=$value2->id;
                $notet->idetudiant=$idetudiant;
                $notet->note1=0;
                $notet->note2=0;
                $notet->note3=0;
                $DB->insert_record('listenote',$notet);
            }
        }
      }
     //je recuperer tout les cours lien aux professeur je l'affecte à un etudiant d'une specialite et cycle precis

    //  $sql_verienr="SELECT * FROM {user_enrolments} WHERE enrolid='".$val->enroleid."' AND userid='".$idetudiant."'";
    //  $verif=$DB->get_records_sql($sql_verienr);

    // die;
    
    // die;
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'les cours ont été bien affectés');
    
}


if($_GET['id']) {

    // $mform->supp_inscription($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Information Bien supprimée');
        
}


// $inscription =$tab = array();

$sql_inscrip = "SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
                s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,s.idfiliere,idcycle,i.idcampus,idspecialite
                FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
                WHERE i.idanneescolaire=a.id AND i.idspecialite=s.id AND i.idetudiant=u.id 
                AND i.idcampus=c.id AND i.idcycle = cy.id" ;

// $inscription = $DB->get_records('inscription', null, 'id');


// var_dump($sql_inscrip);
// die;
$inscription = $DB->get_records_sql($sql_inscrip);
// $i=0;

// var_dump($inscription);
// die;
foreach ($inscription as $key ){

    $time = $key->datedebut;
    $timef = $key->datefin;

    $dated = date('Y',$time);
    $datef = date('Y',$timef);

    $key->datedebut = $dated;
    $key->datefin = $datef;

}

// var_dump($i);
// var_dump($inscription);
// die;

$templatecontext = (object)[
    'inscription' => array_values($inscription),
    // 'nb'=>array_values($tab),
    'inscriptionedit' => new moodle_url('/local/powerschool/inscriptionedit.php'),
    'inscriptionpayer'=> new moodle_url('/local/powerschool/paiement.php'),
    'affectercours'=> new moodle_url('/local/powerschool/inscription.php'),
    // 'imprimer' => new moodle_url('/local/powerschool/imp.php'),
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
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     // 'notes' => new moodle_url('/local/powerschool/note.php'),
//     'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
//     'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
//     'gerer' => new moodle_url('/local/powerschool/gerer.php'),
//     'modepaie' => new moodle_url('/local/powerschool/modepaiement.php'),
//     'statistique' => new moodle_url('/local/powerschool/statistique.php'),

// ];
$menu = (object)[
    'statistique' => new moodle_url('/local/powerschool/statistique.php'),
    'reglage' => new moodle_url('/local/powerschool/reglages.php'),
    // 'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),

    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
    'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),

];

echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/inscription', $templatecontext);


echo $OUTPUT->footer();