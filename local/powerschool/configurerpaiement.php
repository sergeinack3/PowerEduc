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
use local_powerschool\configurerpaiement;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/configurerpaiement.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/configurerpaiement.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('configurerpaie', 'local_powerschool'));
$PAGE->set_heading(get_string('configurerpaie', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('configurerpaie', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new configurerpaiement();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' ) {


$recordtoinsert = new stdClass();

$recordtoinsert->idfiliere=(int)$_POST["idfiliere"];
$recordtoinsert->idcycle=(int)$_POST["idcycle"];
$recordtoinsert->idtranc=(int)$_POST["idtranc"];
$recordtoinsert->somme=(int)$_POST["somme"];
$recordtoinsert->idspecialite=(int)$_POST["idspecialite"];
// $recordtoinsert->datelimite=$_POST["datelimite"];

    // var_dump($recordtoinsert->idtranc,$recordtoinsert->somme,$recordtoinsert->idfiliere,$_POST["idfiliere"],$_POST["idtranc"]);
    // die;
    $ggg=$_POST["datelimite"];
   
    $recordtoinsert->datelimite= strtotime($ggg["day"]."-".$ggg["month"]."-".$ggg["year"]);
    //    var_dump(strtotime($_POST["datelimite"]));die;
       $ff=$DB->insert_record('filierecycletranc', $recordtoinsert);

       redirect($CFG->wwwroot . '/local/powerschool/configurerpaiement.php?idca='.$_POST["idcampus"].'', 'Enregistrement effectué');
       exit;
//     $fromform = $mform->get_data();
//     var_dump("rien",$_POST["idfiliere"]);die;
// var_dump("cvbn");die;
}else{

}

if($_GET['id']) {

    $mform->supp_configpaie($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/configurerpaiement.php', 'Information Bien supprimée');
        
}

$sqlrole="SELECT c.id,t.libelletype FROM {campus} c,{typecampus} t WHERE t.id=c.idtypecampus AND c.id='".$_GET["idca"]."'";
// var_dump($role);die;
$role=$DB->get_records_sql($sqlrole);
foreach($role as $key => $rol)
{}
if($rol->libelletype=="universite")
{
    
    $sql="SELECT conf.id as idconf,libellefiliere,libelletranche,libellecycle,somme,datelimite FROM
      {filierecycletranc} as conf,{filiere} as f,{tranche} as t,{cycle} as cy WHERE
      conf.idfiliere=f.id AND conf.idtranc=t.id AND conf.idcycle=cy.id AND f.idcampus='".$_GET["idca"]."'";
}else{
    $sql="SELECT conf.id as idconf,libellefiliere,libelletranche,libellespecialite,somme,datelimite,f.idcampus FROM
      {filierecycletranc} as conf,{filiere} as f,{tranche} as t,{specialite} as sp WHERE
      conf.idfiliere=f.id AND conf.idtranc=t.id AND conf.idspecialite=sp.id AND f.idcampus='".$_GET["idca"]."'";
}
$configurer = $DB->get_records_sql($sql);
// var_dump($configurer);die;
foreach($configurer as $key =>$vaconf)
{
   $dated=date("d-m-Y",$vaconf->datelimite);
   $vaconf->datelimite=$dated;
}
$templatecontext = (object)[
    'configurer' => array_values($configurer),
    'configedit' => new moodle_url('/local/powerschool/configurerpaiementedit.php'),
    'configsupp'=> new moodle_url('/local/powerschool/configurerpaiement.php'),
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
// ];

$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'confinot' => new moodle_url('/local/powerschool/configurationnote.php'),

    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),

];

$campus=$DB->get_records('campus');
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new moodle_url('/local/powerschool/configurerpaiement.php'),
];
echo $OUTPUT->header();
echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
echo'<div style="margin-top:45px;"></div>';

// $campuss="<label>Choisir l'etablissement</label>
// <select name='campus'onchange='if (this.value) location.href=this.value;' class='form-control '>
// <option value=''></option>";
// foreach($campus as $key =>$vall)
// {
    
    //    $campuss.= "<option value=''".$CFG->wwwroot."'/local/powerschool/configurerpaiement.php?idca='".$vall->id."''>".$vall->libellecampus."</option>";
    // }
    // echo $campuss.="</select>";
    echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);

$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/configurerpaiement', $templatecontext);


echo $OUTPUT->footer();