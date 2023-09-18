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
use local_powerschool\materiels;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/materiels.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/materiels.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('materiel', 'local_powerschool'));
$PAGE->set_heading(get_string('materiel', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new powereduc_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('materiel', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new materiels();
$powereduc_file_name = $CFG->wwwroot;

// var_dump($PAGE);die;

if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/configurationmini.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data() ) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;
    
// var_dump($recordtoinsert);
// die;
// if (!$mform->veri_insc($recordtoinsert->idetudiant)) {
    # code..

    // var_dump($_POST["idcampus"]);die;
    $recordtoinsert=new stdClass();
    $recordtoinsert->libellemate=$_POST["libellemate"];
    $recordtoinsert->idcampus=$_POST["idcampus"];
    $recordtoinsert->quantite=$_POST["quantite"];
    $recordtoinsert->prixuni=$_POST["prixuni"];
    $recordtoinsert->sommetota=$_POST["prixuni"]*$_POST["quantite"];
    $recordtoinsert->description=$_POST["description"];
    $recordtoinsert->idanneescolaire=$_POST["idanneescolaire"];
    $recordtoinsert->usermodified=$USER->id;
    $recordtoinsert->timecreated=time();
    $recordtoinsert->timemodified=time();
    // var_dump($recordtoinsert);die;
    $DB->insert_record('materiels', $recordtoinsert);
    redirect($CFG->wwwroot . '/local/powerschool/materiels.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
    exit;
// }else{
//     redirect($CFG->wwwroot . '/local/powerschool/inscription.php', 'Cet etudiant est déjà inscript');

// }


   


 
   
}



if($_GET['id']) {

    // $mform->supp_inscription($_GET['id']);
    $DB->delete_records("materiels", array("id"=>$_GET["id"]));
    redirect($CFG->wwwroot . '/local/powerschool/materiels.php?idca='.$_GET["id"].'', 'Information Bien supprimée');
        
}


// $inscription =$tab = array();


// var_dump($i);
// var_dump($inscription);
// die;
$message=$DB->get_records("materiels",array("idcampus"=>$_GET["idca"]));
$somme=$DB->get_records_sql("SELECT SUM(sommetota) as sommateriel FROM {materiels} WHERE idcampus='".$_GET["idca"]."'");
$templatecontext = (object)[
    'materiels' => array_values($message),
    'somme' => array_values($somme),
    // 'nb'=>array_values($tab),
    'messagesc' => new powereduc_url('/local/powerschool/PHPMailer/email.php'),
    'inscriptionpayer'=> new powereduc_url('/local/powerschool/paiement.php'),
    'materielssup'=> new powereduc_url('/local/powerschool/materiels.php'),
    'idca'=>$_GET["idca"],
    'powereduc_file_name' => $powereduc_file_name,

    // 'imprimer' => new powereduc_url('/local/powerschool/imp.php'),
];
// $campus=$DB->get_records('campus');
// $campuss=(object)[
//         'campus'=>array_values($campus),
//         'confpaie'=>new powereduc_url('/local/powerschool/affecterprof.php'),
//     ];
$menumini = (object)[
    'affecterprof' => new powereduc_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new powereduc_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new powereduc_url('/local/powerschool/coursspecialite.php'),
    'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
    'salleele' => new powereduc_url('/local/powerschool/salleele.php'),
    'message' => new powereduc_url('/local/powerschool/message.php'),
    'logo' => new powereduc_url('/local/powerschool/logo.php'),
    'confinot' => new powereduc_url('/local/powerschool/configurationnote.php'),
    'materiell' => new powereduc_url('/local/powerschool/materiels.php'),


];

$campus=$DB->get_records("campus");
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new powereduc_url('/local/powerschool/materiels.php'),
];

echo $OUTPUT->header();
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo'<div style="margin-top:55px"></div>';
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/materiels', $templatecontext);


echo $OUTPUT->footer();