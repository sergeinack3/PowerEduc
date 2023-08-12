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

$PAGE->set_url(new moodle_url('/local/powerschool/programme.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Programme de Cours');
$PAGE->set_heading('Programme de Cours');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('programme', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new programme();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($recordtoinsert);
    // var_dump($mform->definir_semestre($recordtoinsert->datecours));
    // die;

  
        $periode = $mform->periode($recordtoinsert->idperiode);

        
            
        for($i=0;$i<=4;$i++)
        {

            $date = $recordtoinsert->datecours ;
            $sem = $mform->definir_semestre($date);

            $recordtoinsert->idsemestre = $sem;

            var_dump($recordtoinsert);
            die;

            $date = $date->modify("+".($i)."week");

        
            

        var_dump($sem);
        var_dump($recordtoinsert);
           
            // $DB->insert_record('programme', $recordtoinsert);
            // redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Enregistrement effectué');
            // exit;

            
        
        }
        die;
        
}

if($_GET['id']) {

    $mform->supp_programme($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/programme.php', 'Information Bien supprimée');
        
}

$sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy, {programme} p WHERE p.idcourses = c.id AND p.idsemestre =s.id AND p.idspecialite = sp.id
        AND p.idcycle = cy.id  ";

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

$templatecontext = (object)[
    'programme' => array_values($programmes),
    'programmeedit' => new moodle_url('/local/powerschool/programmeedit.php'),
    'programmesupp'=> new moodle_url('/local/powerschool/programme.php'),
    'affecter' => new moodle_url('/local/powerschool/affecter.php'),
    'periode' => new moodle_url('/local/powerschool/periode.php'),
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

echo ' <a type="button" class="btn btn-danger" href="/powereduc03/local/powerschool/indexprogramme.php">Voir le Calendrier </a>';


echo $OUTPUT->footer();