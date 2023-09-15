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
use local_powerschool\specialite;
use local_powerschool\tranche;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/tranche.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/tranche.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une '.get_string('tranche', 'local_powerschool'));
$PAGE->set_heading('Enregistrer une '.get_string('tranche', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new powereduc_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('tranche', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new tranche();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

    // var_dump($fromform);
    // die;
 
        $DB->insert_record('tranche', $recordtoinsert);
        redirect($CFG->wwwroot . '/local/powerschool/tranche.php', 'Enregistrement effectué');
        exit;
}

if($_GET['id']) {

    $mform->supp_tranche($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/tranche.php', 'Information Bien supprimée');
        
}


$sql = "SELECT * FROM {tranche}  ";

$tranche = $DB->get_records_sql($sql);

// $specialite = $DB->get_records('specialite', null, 'id');

// var_dump($specialites);
// die;

$templatecontext = (object)[
    'tranche' => array_values($tranche),
    'trancheedit' => new powereduc_url('/local/powerschool/trancheedit.php'),
    'tranchesupp'=> new powereduc_url('/local/powerschool/tranche.php'),
    'cycle' => new powereduc_url('/local/powerschool/cycle.php'),
];

$menumini = (object)[
    'affecterprof' => new powereduc_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new powereduc_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new powereduc_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new powereduc_url('/local/powerschool/salleele.php'),
    'tranche' => new powereduc_url('/local/powerschool/tranche.php'),
    'confinot' => new powereduc_url('/local/powerschool/configurationnote.php'),
    'logo' => new powereduc_url('/local/powerschool/logo.php'),
    'message' => new powereduc_url('/local/powerschool/message.php'),
    'materiell' => new powereduc_url('/local/powerschool/materiels.php'),



];


// $menu = (object)[
//     'annee' => new powereduc_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new powereduc_url('/local/powerschool/campus.php'),
//     'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
//     'salle' => new powereduc_url('/local/powerschool/salle.php'),
//     'filiere' => new powereduc_url('/local/powerschool/filiere.php'),
//     'specialite' => new powereduc_url('/local/powerschool/specialite.php'),
//     'cycle' => new powereduc_url('/local/powerschool/cycle.php'),
//     'modepayement' => new powereduc_url('/local/powerschool/modepayement.php'),
//     'matiere' => new powereduc_url('/local/powerschool/matiere.php'),
//     'seance' => new powereduc_url('/local/powerschool/seance.php'),
//     'inscription' => new powereduc_url('/local/powerschool/inscription.php'),
//     'enseigner' => new powereduc_url('/local/powerschool/enseigner.php'),
//     'paiement' => new powereduc_url('/local/powerschool/paiement.php'),
//     'bulletin' => new powereduc_url('/local/powerschool/bulletin.php'),
// ];



echo $OUTPUT->header();

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
echo html_writer::start_tag("div",array("style"=>"margin-top:40px"));
echo html_writer::end_tag("div");
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/tranche', $templatecontext);


echo $OUTPUT->footer();