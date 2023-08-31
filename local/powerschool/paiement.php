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
use local_powerschool\paiement;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/paiement.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/paiement.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une paiement');
$PAGE->set_heading('Enregistrer une paiement');

$PAGE->navbar->add(get_string('inscription', 'local_powerschool'),  new moodle_url('/local/powerschool/inscription.php'));
$PAGE->navbar->add(get_string('paiement', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new paiement();



if ($mform->is_cancelled()) {
    // var_dump("fgfg");die;

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // var_dump($_POST["idfi"]);die;
    // die;

$recordtoinsert = new stdClass();

// $recordtoinsert = $fromform;

$rolecasql="SELECT * FROM {campus} c,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".$_POST["idca"]."'";
$campus=$DB->get_records_sql($rolecasql);

foreach($campus as $key => $cam)
{}
if($cam->libelletype=="universite"){

    $sql1="SELECT * FROM {filierecycletranc} WHERE idfiliere='".$_POST["idfi"]."' AND idcycle='".$_POST["idcy"]."' AND idtranc='".$_POST["idtranc"]."'";
}else{
    $sql1="SELECT * FROM {filierecycletranc} WHERE idfiliere='".$_POST["idfi"]."' AND idspecialite='".$_POST["idsp"]."' AND idtranc='".$_POST["idtranc"]."'";

}
$filiercycltr = $DB->get_records_sql($sql1);

// var_dump($filiercycltr,$_POST["idfi"],$_POST["idsp"],$_POST["idtranc"]);
// die;
foreach ($filiercycltr as $key => $value) {

    $sql3="SELECT idtranche, sum(montant) as mont FROM {paiement} WHERE idinscription='".$_POST["idinscription"]."' AND idtranche='".$_POST["idtranc"]."'";
    $paieverie = $DB->get_records_sql($sql3);
    foreach ($paieverie as $key => $value1) {
                    // var_dump($value1->mont==$value->somme,$value->somme);
                    // var_dump($value->somme,$value1->mont,$fromform->idtranc);die;
                    if ($value->somme==$value1->mont) {
                        \core\notification::add('Cet etudiant a déjà fini cette etape de la passion', \core\output\notification::NOTIFY_ERROR);
                        redirect($CFG->wwwroot . '/local/powerschool/paiement.php?idins='.$_POST['idinscription'].'&idfi='.$_POST['idfi'].'&idcy='.$_POST['idcy'].'&idca='.$_POST["idca"].'');
                    }else{
                        $recordtoinsert->idmodepaie=$_POST["idmodepaie"];
                        // var_dump($_POST["idmodepaie"]);die;
                        $recordtoinsert->idinscription=$_POST["idinscription"];
                        $recordtoinsert->usermodified=$_POST["usermodified"];
                        $recordtoinsert->timecreated=$_POST["timecreated"];
                        $recordtoinsert->timemodified=$_POST["timemodified"];
                        $recordtoinsert->montant=$_POST["montant"];
                        $recordtoinsert->idtranche=$_POST["idtranc"];
                        // $DB->insert_record('paiement', $recordtoinsert);
                        $DB->execute("INSERT INTO mdl_paiement VALUES(0,'".$recordtoinsert->idmodepaie."','".$recordtoinsert->idinscription."','".$recordtoinsert->usermodified."','".$recordtoinsert->timecreated."','". $recordtoinsert->timemodified."','".$recordtoinsert->montant."','".$recordtoinsert->idtranche."')");
                        redirect($CFG->wwwroot . '/local/powerschool/paiement.php', 'Enregistrement effectué');
                        exit;
                    }
                }
            }
 
}else{
    // var_dump($_POST["idfi"]);die;
}
// die;
if($_GET['id']) {

    $mform->supp_paiement($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/paiement.php', 'Information Bien supprimée');
        
}


// $sql="SELECT * FROM {paiement} as pa RIGHT JOIN {tranche} as t ON pa.idtranche=t.id WHERE pa.idinscription=:idins";

// $paiement = $DB->get_records_sql($sql,array("idins"=>$_GET["idins"]));

$sql = "SELECT pa.id as paid,libelletranche,montant,libellemodepaiement,idinscription as idins FROM {paiement} as pa JOIN {tranche} as t ON pa.idtranche = t.id JOIN {modepaiement} as mo ON pa.idmodepaie=mo.id WHERE pa.idinscription = :idins";

// Les paramètres à lier à la requête
$params = array("idins" => $_GET["idins"]);

// cette fonction retourne tout les lignes attendus sans faire un distinct sur les donnees
//get_records_sql cette fonction retourne en annuler les doublons 
$rs = $DB->get_recordset_sql($sql, $params);

// Convertir l'objet mysqli_native_moodle_recordset en tableau d'enregistrements
$paiement = array();
foreach ($rs as $record) {
    $paiement[] = (array) $record;
}
// foreach ($rs as $key => $value) {
//     # code...
//     var_dump($value->montant);
// }
// // $paiement=$DB->get_records_select("paiement", $select, $params_array, $sort, $fields, $limitfrom, $limitnum);
// die;
$templatecontext = (object)[
    'paiement' => array_values($paiement),
    'paiementedit' => new moodle_url('/local/powerschool/paiementedit.php'),
    'paiementsupp'=> new moodle_url('/local/powerschool/paiement.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'recu' => new moodle_url('/local/powerschool/recu/facture/recu.php'),
    'idins'=>$_GET["idins"],
    'idfi'=>$_GET["idfi"],
];

$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'campus' => new moodle_url('/local/powerschool/campus.php'),
    'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/paiement', $templatecontext);


echo $OUTPUT->footer();