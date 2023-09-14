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
use local_powerschool\Date\Month;
use local_powerschool\programme;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/programme.php');
require_once($CFG->dirroot.'/local/powerschool/classes/date.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/programme.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Programme de Cours');
$PAGE->set_heading('Programme de Cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('programme', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new programme();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/statistique.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST["idsemestre"])) {


$recordtoinsert = new stdClass();

// var_dump($_POST["heuredebutcours"]);die;
// $recordtoinsert = $fromform;

    // var_dump($recordtoinsert);
    // var_dump($mform->definir_semestre($recordtoinsert->datecours));
    // die;

  
        // $periode = $mform->periode($recordtoinsert->idperiode);

        
        $recordtoinsert->heuredebutcours=$_POST["heuredebutcours"];            
        $recordtoinsert->heurefincours=$_POST["heurefincours"]; 
        // $recordtoinsert->idsalle=$_POST["idsalle"]; 
        $recordtoinsert->idcourses=$_POST["idcourses"]; 
        $recordtoinsert->idspecialite=$_POST["idspecialite"]; 
        $recordtoinsert->idcycle=$_POST["idcycle"]; 
        $recordtoinsert->idsalle=$_POST["idsalle"]; 
        $recordtoinsert->idprof=$_POST["idprof"]; 
        $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"]; 
        
        $recordtoinsert->usermodified=$USER->id; 
        $recordtoinsert->timecreated=time(); 
        $recordtoinsert->timemodified=time(); 
        
        // var_dump($_POST["idprof"]);die;
        $datesea=$_POST["datecours"];
        $recordtoinsert->datecours= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);
        
        $verda=$datesea["day"]."-".$datesea["month"]."-".$datesea["year"];
        
        $veriprofss=$DB->get_records_sql("SELECT * FROM {user} u,{coursspecialite} cs,{courssemestre} css,{affecterprof} af,{specialite} s,{filiere} f,{cycle} cy
    WHERE cy.id=cs.idcycle AND cs.idspecialite=s.id AND css.idcoursspecialite=cs.id AND css.id=af.idcourssemestre AND s.idfiliere=f.id AND af.idprof=u.id AND f.idcampus='".$_POST["idcampus"]."' 
    AND s.id='".$_POST["idspecialite"]."' AND cy.id='".$_POST["idcycle"]."' AND u.id='".$_POST["idprof"]."' AND idcourses='".$_POST["idcourses"]."'");
    $verappart=$DB->get_records_sql("SELECT * FROM {programme} WHERE idspecialite='".$_POST["idspecialite"]."' AND idcycle='".$_POST["idcycle"]."' AND DATE_FORMAT(FROM_UNIXTIME(datecours), '%e-%c-%Y')='".$verda."'AND idsemestre='".$_POST["idsemestre"]."' AND heuredebutcours='".$_POST["heuredebutcours"]."' AND heurefincours='".$_POST["heurefincours"]."'");
    // var_dump($veriprof);die;
    // var_dump($verappart,$verda,$_POST["idspecialite"],$_POST["idcycle"],$_POST["idsemestre"]);die;
if(!$verappart){
   
    $semver = $mform->definir_semestre($recordtoinsert->datecours,$_POST["idsemestre"]);
    if($semver==null)
    {

        \core\notification::add('Cette Date n\'est pas dans ce semestre', \core\output\notification::NOTIFY_ERROR);
        redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');

    }
    else
    {
        for($i=0;$i<=$_POST["nobresemaine"];$i++)
        {
            $datesea=$_POST["datecours"];
            $recordtoinsert->datecours= strtotime($datesea["day"]."-".$datesea["month"]."-".$datesea["year"]);

            // $date = $recordtoinsert->datecours ;
            $date =  $recordtoinsert->datecours + ($i * 604800);
            // var_dump(date("Y/m/d",$recordtoinsert->datecours));
            $sem = $mform->definir_semestre($date,$_POST["idsemestre"]);

            $recordtoinsert->idsemestre = $sem;
            // var_dump(date("Y/m/d",$date));
            $recordtoinsert->datecours=$date;
        if($recordtoinsert->heuredebutcours==$recordtoinsert->heurefincours)
        {
            \core\notification::add('Heure de début et de fin sont pareil', \core\output\notification::NOTIFY_ERROR);
            redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
            exit;
        }
        else{

            $veriprof=$DB->get_records_sql("SELECT * FROM {salleele} sa,{inscription} i WHERE sa.idsalle='".$_POST["idsalle"]."'
            AND sa.idetudiant=i.idetudiant AND i.idspecialite='".$_POST["idspecialite"]."' AND i.idcycle='".$_POST["idcycle"]."'");
                if($veriprof)
                   {
                     if($veriprofss)
                      {

                          $DB->insert_record('programme', $recordtoinsert);
                      }
                      else
                      {

                          \core\notification::add('Soit cet enseignant n\'appartient pas à cette specialité
                          <br> Soit il\'enseigne pas à ce cours', \core\output\notification::NOTIFY_ERROR);
                          redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
                      
                      }
                   } 
                else 
                   {
                    $speci=$DB->get_records_sql("SELECT * FROM {specialite} WHERE id='".$_POST["idspecialite"]."'");

                    foreach ($speci as $key => $value) {
                        # code...
                    }
                    \core\notification::add('Cette salle n\'appertient pas à cette specialité '.$value->libellespecialite.'', \core\output\notification::NOTIFY_ERROR);
                    redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');
                
                    exit;
                   }
        }

            // $date = $date->modify("+".($i)."week");
        
            

        
        //    var_dump($recordtoinsert);
        // exit;
        
        
        
    }
    redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
    }
}else
{
    \core\notification::add('Cette Seance est déjà occupée', \core\output\notification::NOTIFY_ERROR);
    redirect($CFG->wwwroot . '/local/powerschool/programme.php?idca='.$_POST["idcampus"].'');

}
        // die;
        
}

if($_GET['id']) {

    $mform->supp_programme($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Information Bien supprimée');
        
}

$sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy, {programme} p WHERE p.idcourses = c.id AND p.idsemestre =s.id AND p.idspecialite = sp.id
        AND p.idcycle = cy.id  AND cy.idcampus='".$_GET["idca"]."'";

    $programmes = $DB->get_records_sql($sql);

    foreach($programmes as $key){
        
        $time = $key->datecours;

        $date = date('d-M-Y',$time);
        $timed = date('H:m',$time);
        $timef = date('H:m',$time);

        $key->datecours = $date;
        // $key->heuredebutcours = $timed;
        // $key->heurefincours = $timef;

    }
    // var_dump($programmes);
    // die;
// $programme = $DB->get_records('programme', null, 'id');

$campus=$DB->get_records('campus');

$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new powereduc_url('/local/powerschool/programme.php'),
            ]; 
$templatecontext = (object)[
    'programme' => array_values($programmes),
    'programmeedit' => new powereduc_url('/local/powerschool/programmeedit.php'),
    'programmesupp'=> new powereduc_url('/local/powerschool/programme.php'),
    'affecter' => new powereduc_url('/local/powerschool/affecter.php'),
    'periode' => new powereduc_url('/local/powerschool/periode.php'),
    'idca' =>$_GET["idca"],
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

// $mois = $_GET['mois'] ;
// $annee = $_GET['annee'];
// $month = new Month($mois??null,$annee??null);
// $start = $month->getStartingDay();
// $getWeeks = $month->getWeeks();
// $getMonth = $month->toString();

// $start = $start->format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');

// $end = (clone $start)->modify('+'.(6 + 7 * ($getWeeks - 1)).'days');
// var_dump($month->toString());

// $events = $month->getEvents($start,$end);
// $eventsByDay = $month->getEventsByDay($start,$end);


// var_dump($start);
// var_dump($getWeeks);
// var_dump($end);


// die;




// echo $OUTPUT->render_from_template('local_powerschool/tableau', $getWeeks);

echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

$mform->display();

echo $OUTPUT->render_from_template('local_powerschool/programme', $templatecontext);


// echo '<div class="d-flex flex-row align-items-center justify-content-between mx-sm-5">
//             <h1>'.$getMonth. '</h1>
//         <div>  
//                 <a href="/powereduc03/local/powerschool/programme.php?mois='.$month->previousmonth()->month.'&annee='.$month->previousmonth()->year.'" class="btn btn-primary"> &lt;</a>
//                 <a href="/powereduc03/local/powerschool/programme.php?mois='.$month->nextmonth()->month.'&annee='.$month->nextmonth()->year.'" class="btn btn-primary">&gt;</a>
//         </div>
//      </div>';

// echo ' <div class="table card mt-2 mb-2">
// <table class="calendar__table">';

// for($i = 0 ; $i < $getWeeks; $i++){

//     echo '<tr>';

//     foreach($month->days as $k => $day)
//     {
//         $date = (clone $start)->modify("+".($k + $i * 7)."days");
//         $eventForDay = $eventsByDay[$date->format('Y-m-d')] ?? [];

//         echo '<td>';
//         if($i === 0)
//         {
//         echo '<div> <strong>'.$day.' </strong></div>';
//         }
//       echo '<div> <strong>'.$date->format('d').' </strong></div>';

//       foreach($eventForDay as  $event){


//         $eventday = $event->fullname;
//         $heuredebut = $event->heuredebutcours;
//         $heurefin = $event->heurefincours;
//         echo '<div>'
//         .$heuredebut.'h -'.$heurefin.'h :   '.'<a href="#?id='.$event->id.'">'.$eventday.'</a>
//         </div>';
//       }
//        '</td>';
//     }
//     echo '</tr>';
// }
// echo ' </table>
//         </div>';

echo ' <a type="button" class="btn btn-danger" href="/powereduc1/local/powerschool/indexprogramme.php?idca='.$_GET["idca"].'">Voir le Calendrier </a>';


echo $OUTPUT->footer();