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

$PAGE->set_url(new powereduc_url('/local/powerschool/absenceetu.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('absenceetu', 'local_powerschool'));
$PAGE->set_heading(get_string('absenceetu', 'local_powerschool'));

// $PAGE->navbar->add(get_string('statistique', 'local_powerschool'),  new powereduc_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('absenceetu', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();

if($_POST["cours"] && $_POST["campus"] && $_POST["abseuser"] && $_POST["cycle"] && $_POST["specialite"] && $_POST["salle"])
{
    $dddd=$DB->get_records_sql("SELECT datecours FROM {programme} WHERE idprof='".$USER->id."' AND idcourses='".$_POST["cours"]."'");
    // var_dump($dddd);
    // die;
    $vericousp=$DB->get_records_sql("SELECT * FROM {coursspecialite} cs,{courssemestre} css,{affecterprof} af,{course} cou
                                     WHERE css.idcoursspecialite=cs.id AND af.idcourssemestre=css.id AND cs.idspecialite='".$_POST["specialite"]."' 
                                     AND cou.id=cs.idcourses AND cs.idcycle='".$_POST["cycle"]."' AND af.idprof='".$USER->id."' AND af.idsalle='".$_POST["salle"]."'");
        //  var_dump($_POST["abseuser"]);
        //         die;
    if($vericousp)
    {
        $tardat=array();
         foreach($dddd as $key => $valu)
         {
            $datecours=date("d-m-Y",$valu->datecours);
            $now=date("d-m-Y");
            // var_dump($datecours,$now);
            if($datecours==$now)
            {
                // var_dump("Bravo");
                $abseusers=$_POST["abseuser"];
               foreach($abseusers as $key => $valabs)
               {
                $absence=new stdClass();
                $absence->idspecialite=$_POST["specialite"];
                $absence->idcycle=$_POST["cycle"];
                $absence->idcourses=$_POST["cours"];
                $absence->idetudiant=$valabs;
                $absence->idprof=$USER->id;
                $absence->idcampus=$_POST["campus"];
                $absence->idanneescolaire=$_POST["anneee"];
                $absence->absence=1;
                $absence->timecreated=time();
                $absence->timemodified=time();

                $DB->insert_record("absenceetu",$absence);
                
                array_push($tardat,$datecours);
            }
            \core\notification::add('Les apprenants absents a votre matiere sont enregistrés', \core\output\notification::NOTIFY_SUCCESS);
            redirect($CFG->wwwroot . '/local/powerschool/absenceetu.php?idca='.$_POST["campus"].'');
            }
        }
        // die;

    }else{
        \core\notification::add('Soit vous n\'appartenais pas à cette specialité. <br>
                                 Soit vous n\'appartenais pas à ce niveau.<br>
                                 Soit ce cours que vous avez n\'appartient à cette specialité ou ce niveau', \core\output\notification::NOTIFY_ERROR);
    redirect($CFG->wwwroot . '/local/powerschool/absenceetu.php?idca='.$_POST["campus"].'');

    }
    // var_dump($now,$tardat);die;
    $no=array_search($now,$tardat);
    if($no===false)
    {
        
        \core\notification::add('Vous avez pas ce cours aujourd\'hui.. ', \core\output\notification::NOTIFY_ERROR);
        redirect($CFG->wwwroot . '/local/powerschool/absenceetu.php?idca='.$_POST["campus"].'');
    }

}







// $inscription =$tab = array();

//cours

//filiere
$sql="SELECT * FROM {filiere} WHERE idcampus='".$_GET["idca"]."'";
// $sql1="SELECT * FROM {salle}";
$filiere=$DB->get_records_sql($sql);
$sql2="SELECT * FROM {campus}";
//cours
$sql3="SELECT c.id,fullname,shortname FROM {course} c,{coursspecialite} cs,{courssemestre} css,{affecterprof} af,{specialite} s,{filiere} f
       WHERE f.id=s.idfiliere AND s.id=cs.idspecialite AND c.id=cs.idcourses AND css.idcoursspecialite=cs.id AND css.id=af.idcourssemestre AND idprof='".$USER->id."' AND f.idcampus='".$_GET["idca"]."'";

$cours=$DB->get_records_sql($sql3);
// $salle=$DB->get_records_sql($sql1);
$campus=$DB->get_records_sql($sql2);
$annee=$DB->get_records("anneescolaire");

foreach($annee as $key => $vallaaa)
{
    $dated=date("Y",$vallaaa->datedebut);
    $datef=date("Y",$vallaaa->datefin);
    $vallaaa->datedebut=$dated;
    $vallaaa->datefin=$datef;
}
$templatecontext = (object)[
    'filiere'=>array_values($filiere),
    'campus'=>array_values($campus),
    'cours'=>array_values($cours),
    'annee'=>array_values($annee),
    'absence'=> new powereduc_url('/local/powerschool/absenceetu.php'),
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


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/absenceetu', $templatecontext);


echo $OUTPUT->footer();