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

$powereduc_file_name = $CFG->wwwroot;

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



$tarspecialcat=array();
        $camp=$DB->get_records("campus",array("id"=>$_GET["idca"]));
        foreach ($camp as $key => $value) {
            # code...
        }
        $categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
        foreach ($categ as $key => $value1categ) {
            # code...
        }
        // $filiere = $DB->get_records('filiere', array("idcampus"=>$_GET["idca"]));
        
        $catfill=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=2");
        $catspecia=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=3");
        foreach($catfill as $key => $valfil)
        {
            $fff=explode("/",$valfil->path);
            $idca=array_search($value1categ->id,$fff);
          if($idca!==false)
          {
            foreach($catspecia as $key => $vallssp)
            {
                $sss=explode("/",$vallssp->path);
                $idfill=array_search($valfil->id,$sss);
                if($idfill!==false)
                {
        
                    // var_dump($vallssp->name);
                    array_push($tarspecialcat,$vallssp->name);
                }
            }
            
          }
        }
        $stringspecialitecat=implode("','",$tarspecialcat);
        // die;
        
        $sql8 = "SELECT s.id,libellespecialite,libellefiliere,abreviationspecialite FROM {filiere} f, {specialite} s WHERE s.idfiliere = f.id AND idcampus='".$_GET["idca"]."' AND libellespecialite IN ('$stringspecialitecat')";

$specialite=$DB->get_records_sql($sql8);
$templatecontext = (object)[
    'specialite'=>array_values($specialite),
    // 'campus'=>array_values($campus),
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
    'powereduc_file_name' => $powereduc_file_name,

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
        'campus'=>array_values($campus),
        'confpaie'=>new powereduc_url('/local/powerschool/listeetuabsenadmin.php'),
    ];
echo $OUTPUT->header();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo '<div style="margin-top:20px";><wxcvbn</div>';
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();

// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/listeetuabsenadmin', $templatecontext);


echo $OUTPUT->footer();