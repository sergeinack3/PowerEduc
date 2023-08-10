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
use local_powerschool\campus;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/campus.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/campus.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer un Campus');
$PAGE->set_heading('Enregistrer un Campus');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('Campus', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new campus();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if (  $_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {

    // $file_info = $mform->get_file_manager("");
    // $ffff=file_get_submitted_draft_itemid("logocampus");
    // $file_content = file_save_draft_area_files($draftitemid, $context->id, 'mod_plugin', 'logocampus', 0, array('subdirs' => 0, 'maxfiles' => 1));


    // $file_path = $file_info['tmp_name'];

    // var_dump($file_content);die;
    $recordtoinsert = new stdClass();
    $recordtoinsert = $fromform;
    // var_dump($recordtoinsert);die;
    
    // $file_content=$mform->get_file_content($fromform->logocampus);
    // $unique_filename =  $mform->get_new_filename($fromform->logocampus);
    // $destination_path =$CFG->wwwroot .'/local/powerschool/logo/' . $unique_filename;
    // var_dump($fromform->logocampus);
    // die;
        //  file_put_contents($destination_path, $file_content);
        // $recordtoinsert->logocampus=$destination_path;
        if(!$mform->veri_Campus($recordtoinsert->libellecampus))
        {

            $DB->insert_record('campus', $recordtoinsert);
            redirect($CFG->wwwroot . '/local/powerschool/campus.php', 'Enregistrement effectué');
        }
        else{

            \core\notification::add('Ce campus execite déjà', \core\output\notification::NOTIFY_ERROR);
        }

        // exit;
}

if($_GET['id']) {

    $mform->supp_campus($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/campus.php', 'Information Bien supprimée');
        
}

$campus = $DB->get_records_sql('SELECT c.id as camid ,libellecampus,libelletype,abrecampus,adressecampus,emailcampus,telcampus,sitecampus,payscampus,villecampus FROM {campus} c,{typecampus} t WHERE t.id=c.idtypecampus');

$templatecontext = (object)[
    'campus' => array_values($campus),
    'campusedit' => new moodle_url('/local/powerschool/campusedit.php'),
    'campussupp'=> new moodle_url('/local/powerschool/campus.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
];

$menu = (object)[
    'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
    'campus' => new moodle_url('/local/powerschool/campus.php'),
    'semestre' => new moodle_url('/local/powerschool/semestre.php'),
    'salle' => new moodle_url('/local/powerschool/salle.php'),
    'filiere' => new moodle_url('/local/powerschool/filiere.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
    'matiere' => new moodle_url('/local/powerschool/matiere.php'),
    'seance' => new moodle_url('/local/powerschool/seance.php'),
    'inscription' => new moodle_url('/local/powerschool/inscription.php'),
    'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
    'paiement' => new moodle_url('/local/powerschool/paiement.php'),
    'programme' => new moodle_url('/local/powerschool/programme.php'),
    // 'notes' => new moodle_url('/local/powerschool/note.php'),
    'bulletin' => new moodle_url('/local/powerschool/bulletin.php'),
    'configurermini' => new moodle_url('/local/powerschool/configurationmini.php'),
    'gerer' => new moodle_url('/local/powerschool/gerer.php'),
    'modepaie' => new moodle_url('/local/powerschool/modepaiement.php'),
    'statistique' => new moodle_url('/local/powerschool/statistique.php'),


];


echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/campus', $templatecontext);


echo $OUTPUT->footer();