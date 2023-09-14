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
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/rentrernote.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Entrer les '.$_GET['libelcou'].'');
$PAGE->set_heading('Bulletin de Notes');

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('bulletin', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();









// $inscription =$tab = array();

//cours

//filiere
$sql="SELECT * FROM {filiere} WHERE idcampus='".$_GET["idca"]."'";
$filiere=$DB->get_records_sql($sql);
$campus=$DB->get_records("campus");
$templatecontext = (object)[
    'filiere'=>array_values($filiere),
    'campus'=>array_values($campus),
    'ajoute'=> new powereduc_url('/local/powerschool/inscription.php'),
    'affectercours'=> new powereduc_url('/local/powerschool/inscription.php'),
    'ajou'=> new powereduc_url('/local/powerschool/classes/entrernote.php'),
    'coursid'=> new powereduc_url('/local/powerschool/entrernote.php'),
    'bulletinnote'=> new powereduc_url('/local/powerschool/bulletinnote.php'),
    'campuslien'=> new powereduc_url('/local/powerschool/bulletin.php'),
    'root'=>$CFG->wwwroot,
    'idca'=>$_GET["idca"],

 ];

//  $menu = (object)[
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


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/bulletin', $templatecontext);


echo $OUTPUT->footer();