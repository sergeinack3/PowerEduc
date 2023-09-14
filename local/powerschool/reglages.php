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
use local_powerschool\reglages;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/reglage.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/reglages.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('reglages', 'local_powerschool'));
$PAGE->set_heading(get_string('reglages', 'local_powerschool'));

$PAGE->navbar->add('Administration du Site', $CFG->wwwroot.'/admin/search.php');
$PAGE->navbar->add(get_string('reglages', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new reglages();



$templatecontext = (object)[
    // 'reglages' => array_values($reglages),
    'reglagesedit' => new powereduc_url('/local/powerschool/reglagesedit.php'),
    'reglagessupp'=> new powereduc_url('/local/powerschool/reglages.php'),
    'filiere' => new powereduc_url('/local/powerschool/filiere.php'),
];

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


// echo $OUTPUT->render_from_template('local_powerschool/reglages', $templatecontext);

echo html_writer::start_div("card",array('style' => "width: 100%;")) ;
echo"  <div class='card-header text-center'>
<p class=''> Gérer les réglages de vos Etablissements</p>
</div>";
echo" <ul class='list-group list-group-flush'>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/anneescolaire.php'),get_string('annee', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</il>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/campus.php'),get_string('campus', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/semestre.php'),get_string('semestre', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/salle.php'),get_string('salle', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/filiere.php'),get_string('filiere', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/specialite.php'),get_string('specialite', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/cycle.php'),get_string('cycle', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    // echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/logo.php'),"Logo",array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
    echo "<li class='list-group-item '>".html_writer::link(new powereduc_url('/local/powerschool/modepaiement.php'),get_string('modepaiement', 'local_powerschool'),array("class"=>"fw-bold text-decoration-none fs-1 text-uppercase"))."</li>";echo "<br/>";
 echo"</ul>";
echo html_writer::end_div();

echo $OUTPUT->footer();