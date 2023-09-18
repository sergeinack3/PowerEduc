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
use local_powerschool\inscription;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/inscription.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/inscription.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Liste des etudiants');
$PAGE->set_heading('Liste des Etudiants Et affectation de cours');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('listeetudiant', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');






// $inscription =$tab = array();
$powereduc_file_name = $CFG->wwwroot;

$sql_inscrip = "SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus,i.idetudiant, 
                s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,s.idfiliere,idcycle,i.idcampus,idspecialite
                FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy
                WHERE i.idanneescolaire=a.id AND i.idspecialite=s.id AND i.idetudiant=u.id 
                AND i.idcampus=c.id AND i.idcycle = cy.id AND i.idspecialite='".$_GET["specialite"]."' AND i.idcycle='".$_GET["cycle"]."' AND i.idanneescolaire='".$_GET["annee"]."' AND s.idfiliere='".$_GET["filiere"]."' AND i.idcampus='".$_GET["campus"]."'" ;

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

    // die;
    $salle=$DB->get_records_sql("SELECT sa.id,numerosalle FROM {salle} sa,{salleele} saa WHERE sa.id=saa.idsalle AND saa.idetudiant='".$key->idetudiant."'");

    foreach($salle as $sallee)
    {

    }
    $key->numerosalle=$sallee->numerosalle;
    $key->idsa=$sallee->id;
}

// var_dump($i);
// var_dump($inscription);
// die;
$annee=$DB->get_records("anneescolaire");
$campus=$DB->get_records("campus");
foreach($annee as $key => $ab)
            {
                $time = $ab->datedebut;
                $timef = $ab->datefin;

                $dated = date('Y',$time);
                $datef = date('Y',$timef);

                $ab->datedebut = $dated;
                $ab->datefin = $datef;
            }
$templatecontext = (object)[
    'inscription' => array_values($inscription),
    // 'nb'=>array_values($tab),
    'inscriptionedit' => new moodle_url('/local/powerschool/inscriptionedit.php'),
    'inscriptionpayer'=> new moodle_url('/local/powerschool/paiement.php'),
    'affectercours'=> new moodle_url('/local/powerschool/inscription.php'),
    'suppins'=> new moodle_url('/local/powerschool/inscription.php'),
    // 'imprimer' => new moodle_url('/local/powerschool/imp.php'),
    'anneee'=>array_values($annee),
    'roote'=>$CFG->wwwroot,
    'campus1' => array_values($campus),
    'idca'=>$_GET["campus"],
    'idsp'=>$_GET["specialite"],
    'idcy'=>$_GET["cycle"],
    'idan'=>$_GET["annee"],
    'idfi'=>$_GET["filiere"],
    'powereduc_file_name' => $powereduc_file_name,

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
    'listeetudiant' => new moodle_url('/local/powerschool/listeetudiant.php'),
    // 'gerer' => new moodle_url('/local/powerschool/gerer.php'),

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
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/listeetudiant', $templatecontext);


echo $OUTPUT->footer();