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
use local_powerschool\filiere;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/filiere.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/filiere.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une filiere');
$PAGE->set_heading('Enregistrer une filiere');

$PAGE->navbar->add(get_string('reglages', 'local_powerschool'),  new moodle_url('/local/powerschool/reglages.php'));
$PAGE->navbar->add(get_string('filiere', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new filiere();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/reglages.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 if (!$mform->verifiliere($recordtoinsert->libellefiliere,$recordtoinsert->idcampus)) {
    # code...
    
    // $recordcampus=new stdClass();

    //         $recordcampus->name=$recordtoinsert->libellefiliere;
    //         $recordcampus->descriptionformat=1;
    //         $recordcampus->visible=1;
    //         $recordcampus->visibleold=1;
    //         $recordcampus->timemodified=time();
    //         $recordcampus->depth=2;
    //         $idd=$DB->insert_record('course_categories',$recordcampus);
            
    //         $recordcampusmod=new stdClass();
    //         $recordcampusmod->id=$idd;
    //         $recordcampusmod->path= "/".$recordtoinsert->idcampus."/".$idd;
            
    //         $DB->update_record('course_categories',$recordcampusmod);
    $camp=$DB->get_records("campus",array("id"=>$recordtoinsert->idcampus));
    foreach ($camp as $key => $value) {
        # code...
    }
    $categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
    foreach ($categ as $key => $value1) {
        # code...
    }
    // var_dump($value1->name);die;
    $DB->insert_record('filiere', $recordtoinsert);
    redirect($CFG->wwwroot . '/course/editcategory.php?parent='.$value1->id.'&filiere='.$recordtoinsert->libellefiliere.'&idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
    exit;
} else {
    //  redirect($CFG->wwwroot . '/local/powerschool/filiere.php', 'Cette filiere excite');
    \core\notification::add('Cette filiere existe', \core\output\notification::NOTIFY_ERROR);

 }
 
}

if($_GET['id'] && $_GET['idca']) {

    $mform->supp_filiere($_GET['id'],$_GET['idca'],$_GET['libelle']);
    redirect($CFG->wwwroot . '/local/powerschool/filiere.php?idca='.$_GET['idca'].'', 'Information Bien supprimée');
        
}



// var_dump($mform->selectfiliere());
// die;
// if($_POST["categorie"])
// {
//     $camp=$DB->get_records("campus",array("id"=>$_POST["campus"]));
//     foreach ($camp as $key => $value) {
//         # code...
//     }
//     $categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
//     foreach ($categ as $key => $value1) {
//         # code...
//     }
//     // var_dump($value1->name);die;
//     redirect($CFG->wwwroot . '/course/editcategory.php?parent='.$value1->id.'&filiere='.$_POST["filiere"].'');
// }
$camp=$DB->get_records("campus",array("id"=>$_GET["idca"]));
foreach ($camp as $key => $value) {
    # code...
}
$categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
foreach ($categ as $key => $value1categ) {
    # code...
}
$filiere = $DB->get_records('filiere', array("idcampus"=>$_GET["idca"]));



// die;
$tarfilierecat=array();


if(!empty($_GET["idca"]))
{
    // $_GET["idca"]
    // die;
   
    $catfill=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=2");
    foreach($catfill as $key => $valfil)
    {
        $fff=explode("/",$valfil->path);
        $idca=array_search($value1categ->id,$fff);
      if($idca!==false)
      {

        array_push($tarfilierecat,$valfil->name);
    }
    
}
    $stringfilierecat=implode("','",$tarfilierecat);
    // var_dump($stringfilierecat);
    // die;
    $filierecat = $DB->get_records_sql("SELECT * FROM {filiere} WHERE idcampus ='".$_GET["idca"]."' AND libellefiliere NOT IN ('$stringfilierecat')");
    // var_dump($filierecat);
    // die;
    
    $filierecat1 = $DB->get_records_sql("SELECT * FROM {filiere} WHERE idcampus ='".$_GET["idca"]."' AND libellefiliere IN ('$stringfilierecat')");
}else
{
    $filierecat[]="";
    $filierecat1[]="";
    // $tarfilierecat[]="";
    // $tarfilierecat1[]="";
}
// var_dump($filierecat);die;
$campus=$DB->get_records("campus");
$vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t
                                WHERE t.id=c.idtypecampus AND c.id='".$_GET["idca"]."'");    
            foreach($vericam as $key => $ver)
            { 
                if($ver->libelletype=="college"|| $ver->libelletype=="lycee")
                {

                    $table='
                    <input type="checkbox" class="toutpr">
                    <tr>
                        <td style="font-size:17px;font-weight:700;"><input type="checkbox" name="filiere[]" class="checkboxItem" value="Economique et sociale">Economique et sociale</td>
                        <td style="font-size:17px;font-weight:700;"><input type="checkbox" name="filiere[]" class="checkboxItem" value="Scientifique">Scientifique</td>
                        <td style="font-size:17px;font-weight:700;"><input type="checkbox" name="filiere[]" class="checkboxItem" value="Littéraire">Littéraire </td>
                        <td style="font-size:17px;font-weight:700;"><input type="checkbox" name="filiere[]" class="checkboxItem" value="Sciences et Technologies du Management et de la Gestion">Sciences et Technologies du Management et de la Gestion </td>
                    </tr>';
                }else if($ver->libelletype=="primaire")
                {

                    $table='
                    <input type="checkbox" class="toutpr">
                    <tr>
                        <td style="font-size:17px;font-weight:700;"><input type="checkbox" name="filiere[]" class="checkboxItem" value="standard">standard</td>
                    </tr>';
                }
            }
            // var_dump(urldecode($_GET["filiere"]));die;
$templatecontext = (object)[
    'filiere' => array_values($filierecat1),
    'filierecat' => array_values($filierecat),
    'campus' => array_values($campus),
    'table' => $table,
    'filiereedit' => new moodle_url('/local/powerschool/filiereedit.php'),
    'filieresupp'=> new moodle_url('/local/powerschool/filiere.php'),
    'specialite' => new moodle_url('/local/powerschool/specialite.php'),
    'specialiteexe' => new moodle_url('/local/powerschool/specialiteexe.php'),
    'catfiliere' => new moodle_url('/course/editcategory.php'),
    'cattfiliere' => new moodle_url('/local/powerschool/filiere.php'),
    'root'=>$CFG->wwwroot,
    'idca'=>$_GET["idca"],
    'filiereca'=>urlencode($_GET["filiere"]),
    'category'=>$value1categ->id,
    'categorychoi'=>"la categorie choisie est ".$_GET["filiere"]."",

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

];

$campus = $DB->get_records('campus');

$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new moodle_url('/local/powerschool/filiere.php'),
            ]; 

echo $OUTPUT->header();
// if($_GET["filiere"]!=null || $_GET["filiere"]!=0)
// {
    // }
    // echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
    echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
    
    $mform->display();
    
    
    echo $OUTPUT->render_from_template('local_powerschool/filiere', $templatecontext);
    


echo $OUTPUT->footer();