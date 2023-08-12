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
// require_once($CFG->dirroot.'/local/powerschool/classes/configurerpaiement.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/logo.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Ajouter logo');
$PAGE->set_heading('Ajouter logo');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('seance', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$campus=$DB->get_records("campus");
$templatecontext = (object)[
    'campus' => array_values($campus),
    'logo' => new moodle_url('/local/powerschool/classes/addlogo.php'),
    'configedit' => new moodle_url('/local/powerschool/logoedit.php'),
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

$campus=$DB->get_records('campus');
$campuss=(object)[
        'campus'=>array_values($campus),
        'confpaie'=>new moodle_url('/local/powerschool/affecterprof.php'),
    ];
$menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),

];
echo $OUTPUT->header();


echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/logo', $templatecontext);


echo $OUTPUT->footer();