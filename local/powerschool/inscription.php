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
use local_powerschool\inscription;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/inscription.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/inscription.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('inscription de Cours');
$PAGE->set_heading('inscription de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new inscription();
$powereduc_file_name = $CFG->wwwroot;



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST["idcycle"]) {


$recordtoinsert = new stdClass();

// $recordtoinsert = $fromform;
    
// var_dump($recordtoinsert);
// die;
// var_dump($_POST["idcycle"]);die;
$datesea=$_POST["date_naissance"];
$date_naissance= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);

if (!$mform->veri_insc($_POST["idetudiant"])) {
    # code...
    $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"];
    $recordtoinsert->idspecialite=$_POST["idspecialite"];
    $recordtoinsert->idcycle=$_POST["idcycle"];
    $recordtoinsert->idcampus=$_POST["idcampus"];
    $recordtoinsert->idetudiant=$_POST["idetudiant"];
    // $recordtoinsert->idcycle=$fromform->cycle;
    $recordtoinsert->nomsparent=$_POST["nomsparent"];
    $recordtoinsert->telparent=$_POST["telparent"];
    $recordtoinsert->emailparent=$_POST["emailparent"];
    $recordtoinsert->gender=$_POST["gender"];
    $recordtoinsert->date_naissance=$date_naissance;
    $recordtoinsert->professionparent=$_POST["professionparent"];
    $recordtoinsert->usermodified=$_POST["usermodified"];
    $recordtoinsert->timecreated=$_POST["timecreated"];
    $recordtoinsert->timemodified=$_POST["timemodified"];

    // var_dump($date_naissance);die;
    $DB->insert_record('inscription', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
    exit;
}else{
    \core\notification::add('Cet etudiant est déjà inscrit', \core\output\notification::NOTIFY_ERROR);
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php');

}


   


 
   
}


if($_GET['id'] && $_GET['action']='affectercours') {

$veriaff=$DB->get_records_sql("SELECT c.id as coursid,c.fullname,en.id as enroleid FROM {coursspecialite} cs,{course} c,{courssemestre} css,{affecterprof} af,{enrol} en
                               WHERE cs.idspecialite='".$_GET["idsp"]."' AND cs.idcycle='".$_GET["idcy"]."' AND en.courseid=c.id
                               AND cs.idcourses=c.id AND css.idcoursspecialite=cs.id AND af.idcourssemestre=css.id");
$veripaie=$DB->get_records("paiement",array("idinscription"=>$_GET['id']));

// var_dump($veriaff);die;
 if($veripaie)
    {
      if($veriaff)
      {
                $getid = $_GET['id'];

                $sql_get_inscrip = "SELECT idetudiant FROM {inscription} WHERE id = $getid " ;

                $req = $DB->get_records_sql($sql_get_inscrip);
                
                foreach ($req as $key=>$val){
                    $idetudiant = $key;
                } 
                
                
                //Affectation des cours de la specialite a l'etudiant
                $sql_cours = "SELECT c.id as courseid, c.fullname, e.id as enroleid, e.enrol,cs.idspecialite,cs.idcycle FROM 
                {inscription} i, {user} u, {specialite} s, {coursspecialite} cs, {course} c, {enrol} e WHERE i.idetudiant=u.id 
                AND i.idspecialite=s.id AND cs.idspecialite=s.id AND cs.idcourses=c.id AND e.courseid = c.id AND e.enrol='manual' 
                AND i.idetudiant = $idetudiant AND cs.idspecialite='".$_GET["idsp"]."' AND cs.idcycle='".$_GET["idcy"]."' AND c.id=cs.idcourses";


// var_dump($sql_get_inscrip);
// var_dump($req);
// var_dump($veriaff);

// die;
$tarcon=array();

// $spc=$DB->get_records_sql('SELECT * FROM {course} WHERE id="'.$_POST["cours"].'"');
// $tarcon=array();
// $cont=$DB->get_records_sql("SELECT * FROM {context} WHERE contextlevel=50");
// foreach ($cont as $key => $value4) {
    //     array_push($tarcon,$value4->id);
    //    }
    
    $recuperer_cours=array();
    
    $recuperer_cours = $DB->get_records_sql($sql_cours);
    // die;

            // var_dump(  $recuperer_cours );
            // die;

            foreach ($recuperer_cours as $key=>$val){
                $cont=$DB->get_records_sql("SELECT * FROM {context} WHERE contextlevel=50 AND instanceid='".$val->courseid."'");
                foreach ($cont as $key => $value4) {
                    // array_push($tarcon,$value4->id);
                    // var_dump($value4->id,$val->fullname);die;
                    }
                $sql_verienr="SELECT * FROM {user_enrolments} WHERE enrolid='".$val->enroleid."' AND userid='".$idetudiant."'";
                $verif=$DB->get_records_sql($sql_verienr);
                // var_dump($verif);die;
            if (!$verif) {
                # code...
            
                // $sql_enrol = "INSERT INTO {user_enrolments} (`status`, `enrolid`, `userid`, `timestart`, `timeend`, `modifierid`, `timecreated`, `timemodified`) 
                //             VALUES ('0',$val->enroleid,$idetudiant,'0','0',$USER->id,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
                $sql_enrol = [
                
                    "status"=>0,
                    "enrolid"=> $val->enroleid,
                    "userid"=>$idetudiant,
                    "timestart"=>time(),
                    "timeend"=>0,
                    "modifierid"=>$USER->id,
                    "timecreated"=>time(),
                    "timemodified"=>time()];
                $sql_roleass=[
                    "roleid"=>5,
                    "contextid"=>$value4->id,
                    "userid"=>$idetudiant,
                    "timemodified"=>time(),
                    "modifierid"=>$USER->id,
                    "itemid"=>0,
                    "sortorder"=>0,
                ];
                    // var_dump($recuperer_cours);die;
                    
                    // var_dump($val->fullname);
                    // die;
                    
                    $DB->insert_record('user_enrolments', $sql_enrol);
                    $DB->insert_record('role_assignments', $sql_roleass);
                    
                
                        
                }


            }
            //  die;       
            $sql="SELECT * FROM {coursspecialite} WHERE idspecialite='".$val->idspecialite."' AND idcycle='".$val->idcycle."'";
            $listenote=$DB->get_records_sql($sql);
            foreach ($listenote as $key => $value) {
                $sql1="SELECT * FROM {courssemestre} WHERE idcoursspecialite='".$value->id."'";
                $listenote1=$DB->get_records_sql($sql1);
                
                foreach ($listenote1 as $key => $value1) {
                    # code...
                    $sql2="SELECT * FROM {affecterprof} c WHERE c.idcourssemestre='".$value1->id."' AND idsalle='".$_GET["idsa"]."' AND quit=0";
                    $listenote2=$DB->get_records_sql($sql2);
                    // var_dump($listenote2);
                    // var_dump($listenote1);die;
                    foreach ($listenote2 as $key => $value2) {
                        // var_dump($value2->id);
                        // var_dump($value2->id); 
                    $verliste=$DB->get_records("listenote",array("idaffecterprof"=>$value2->id,"idetudiant"=>$idetudiant));
                    if(!$verliste){

                        $notet=new stdClass();
                        $notet->idaffecterprof=$value2->id;
                        $notet->idetudiant=$idetudiant;
                        $notet->note1=0;
                        $notet->note2=0;
                        $notet->note3=0;
                        $notet->retirersalle=0;
                        //  var_dump($notet);
                        $DB->insert_record('listenote',$notet);
                    }
                    }
                }
            }
            //je recuperer tout les cours lien aux professeur je l'affecte à un etudiant d'une specialite et cycle precis

            //  $sql_verienr="SELECT * FROM {user_enrolments} WHERE enrolid='".$val->enroleid."' AND userid='".$idetudiant."'";
            //  $verif=$DB->get_records_sql($sql_verienr);

            // die;
            
            // die;
            // die;
                if($_GET["liste"]=="listeet"){

                    redirect($CFG->wwwroot . '/local/powerschool/listeetudiant.php?campus='.$_GET["idca"].'&specialite='.$_GET["idsp"].'&cycle='.$_GET["idcy"].'&filiere='.$_GET["idfi"].'&annee='.$_GET["idan"].'', 'les cours ont été bien affectés');
                }
                    redirect($CFG->wwwroot . '/local/powerschool/inscription.php?idca='.$_GET["idca"].'', 'les cours ont été bien affectés');
        }else{
            if($_GET["liste"]=="listeet"){
                \core\notification::add('Affecter au moins un cours à un enseignants', \core\output\notification::NOTIFY_ERROR);
                redirect($CFG->wwwroot . '/local/powerschool/listeetudiant.php?campus='.$_GET["idca"].'&specialite='.$_GET["idsp"].'&cycle='.$_GET["idcy"].'&filiere='.$_GET["idfi"].'&annee='.$_GET["idan"].'');
            }   
            \core\notification::add('Affecter au moins un cours à un enseignants', \core\output\notification::NOTIFY_ERROR);
                redirect($CFG->wwwroot . '/local/powerschool/inscription.php?idca='.$_GET["idca"].'');
        } 
    }else{
        if($_GET["liste"]=="listeet"){
            \core\notification::add("Cet apprenant n'a pas encore commercé le paiement", \core\output\notification::NOTIFY_ERROR);
            redirect($CFG->wwwroot . '/local/powerschool/listeetudiant.php?campus='.$_GET["idca"].'&specialite='.$_GET["idsp"].'&cycle='.$_GET["idcy"].'&filiere='.$_GET["idfi"].'&annee='.$_GET["idan"].'');
        }   
        \core\notification::add("Cet apprenant n'a pas encore commercé le paiement", \core\output\notification::NOTIFY_ERROR);
            redirect($CFG->wwwroot . '/local/powerschool/inscription.php?idca='.$_GET["idca"].'');
    }   
}

if($_GET['idins']) {

    $mform->supp_inscription($_GET['idins']);
    redirect($CFG->wwwroot . '/local/powerschool/inscription.php?idca='.$_GET["idca"].'', 'Information Bien supprimée');
        
}


// $inscription =$tab = array();

$sql_inscrip = "SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
                s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,s.idfiliere,idcycle,i.idcampus,idspecialite
                FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
                WHERE i.idanneescolaire=a.id AND i.idspecialite=s.id AND i.idetudiant=u.id 
                AND i.idcampus=c.id AND i.idcycle = cy.id AND i.idcampus='".$_GET["idca"]."'" ;

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
$campus=$DB->get_records("campus");
$templatecontext = (object)[
    'inscription' => array_values($inscription),
    // 'nb'=>array_values($tab),
    'inscriptionedit' => new powereduc_url('/local/powerschool/inscriptionedit.php'),
    'inscriptionpayer'=> new powereduc_url('/local/powerschool/paiement.php'),
    'affectercours'=> new powereduc_url('/local/powerschool/inscription.php'),
    'suppins'=> new powereduc_url('/local/powerschool/inscription.php'),
    'idca'=>$_GET["idca"],
    'powereduc_file_name' => $powereduc_file_name,

    // 'imprimer' => new powereduc_url('/local/powerschool/imp.php'),
];
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new powereduc_url('/local/powerschool/inscription.php'),
];
// $menu = (object)[
//     'annee' => new powereduc_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new powereduc_url('/local/powerschool/campus.php'),
//     'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
//     'salle' => new powereduc_url('/local/powerschool/salle.php'),
//     'filiere' => new powereduc_url('/local/powerschool/filiere.php'),
//     'cycle' => new powereduc_url('/local/powerschool/cycle.php'),
//     'modepayement' => new powereduc_url('/local/powerschool/modepayement.php'),
//     'matiere' => new powereduc_url('/local/powerschool/matiere.php'),
//     'seance' => new powereduc_url('/local/powerschool/seance.php'),
//     'inscription' => new powereduc_url('/local/powerschool/inscription.php'),
//     'enseigner' => new powereduc_url('/local/powerschool/enseigner.php'),
//     'paiement' => new powereduc_url('/local/powerschool/paiement.php'),
//     'programme' => new powereduc_url('/local/powerschool/programme.php'),
//     // 'notes' => new powereduc_url('/local/powerschool/note.php'),
//     'bulletin' => new powereduc_url('/local/powerschool/bulletin.php'),
//     'configurermini' => new powereduc_url('/local/powerschool/configurationmini.php'),
//     'gerer' => new powereduc_url('/local/powerschool/gerer.php'),
//     'modepaie' => new powereduc_url('/local/powerschool/modepaiement.php'),
//     'statistique' => new powereduc_url('/local/powerschool/statistique.php'),

// ];
$menu = (object)[
    'statistique' => new powereduc_url('/local/powerschool/statistique.php'),
    'reglage' => new powereduc_url('/local/powerschool/reglages.php'),
    // 'matiere' => new powereduc_url('/local/powerschool/matiere.php'),
    'seance' => new powereduc_url('/local/powerschool/seance.php'),
    'programme' => new powereduc_url('/local/powerschool/programme.php'),

    'inscription' => new powereduc_url('/local/powerschool/inscription.php'),
    // 'notes' => new powereduc_url('/local/powerschool/note.php'),
    'bulletin' => new powereduc_url('/local/powerschool/bulletin.php'),
    'configurermini' => new powereduc_url('/local/powerschool/configurationmini.php'),
    'listeetudiant' => new powereduc_url('/local/powerschool/listeetudiant.php'),
    // 'gerer' => new powereduc_url('/local/powerschool/gerer.php'),

    //navbar
    'statistiquenavr'=>get_string('statistique', 'local_powerschool'),
    'reglagenavr'=>get_string('reglages', 'local_powerschool'),
    'listeetudiantnavr'=>get_string('listeetudiant', 'local_powerschool'),
    'seancenavr'=>get_string('seance', 'local_powerschool'),
    'programmenavr'=>get_string('programme', 'local_powerschool'),
    'inscriptionnavr'=>get_string('inscription', 'local_powerschool'),
    'configurationminini'=>get_string('configurationminini', 'local_powerschool'),
    'bulletinnavr'=>get_string('bulletin', 'local_powerschool'),

];

echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
echo '<div style="margin-top:80px";><wxcvbn</div>';
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/inscription', $templatecontext);


echo $OUTPUT->footer();