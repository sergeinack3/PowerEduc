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
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/Toutbulletin.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Bulletins');
// $PAGE->set_heading('Bulletin');

$PAGE->navbar->add('Administration du Site',  new powereduc_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('inscription', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();




// if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //   $_POST["idsp"];
    //   $_POST["idcy"];
      $sql1="SELECT idetudiant FROM {listenote} li,{affecterprof} af,{coursspecialite} co,{course} scou,{user} as u,{filiere} as fi,
      {specialite} as sp,{cycle} as cy,{courssemestre} cse,{bulletin} bu, {campus} ca,{typecampus} tcp 
      WHERE tcp.id=ca.idtypecampus AND bu.idspecialite=sp.id AND bu.idcycle=cy.id AND bu.idcampus=ca.id AND li.idbulletin=bu.id AND af.id=li.idaffecterprof AND cse.id=af.idcourssemestre 
      AND co.idcourses=scou.id AND u.id=li.idetudiant AND cy.id=co.idcycle AND sp.id=co.idspecialite AND fi.id=sp.idfiliere
      AND cse.idcoursspecialite=co.id AND sp.id='". $_GET["idsp"]."' AND cy.id='".$_GET["idcy"]."'";

      $bulletins=$DB->get_records_sql($sql1);

    //   foreach($bulletins as $key=>$bulletin){
    //     redirect($CFG->wwwroot . '/local/powerschool/recu/facture/Toutbulletin.php?idetu='.$bulletin->idetudiant.'', 'Bien supp');

    //   }
           
// }

// var_dump($bulletins,$_GET["idsp"]);die;



// $inscription =$tab = array();

//cours

//filiere
// $sql="SELECT * FROM {filiere}";
// $filiere=$DB->get_records_sql($sql);

$templatecontext = (object)[
    'bulletins'=>array_values($bulletins),
    'bulletin'=> new powereduc_url('/local/powerschool/recu/facture/Toutbulletin.php'),
    // 'affectercours'=> new powereduc_url('/local/powerschool/inscription.php'),
    // 'ajou'=> new powereduc_url('/local/powerschool/classes/entrernote.php'),
    // 'coursid'=> new powereduc_url('/local/powerschool/entrernote.php'),
    // 'bulletinnote'=> new powereduc_url('/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'idsp'=>$_GET["idsp"],
    'idcy'=>$_GET["idcy"],

 ];

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


echo $OUTPUT->render_from_template('local_powerschool/Toutbullutin', $templatecontext);


echo $OUTPUT->footer();