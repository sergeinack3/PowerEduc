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
use local_powerschool\configurerpaiement;

require_once(__DIR__ . '/../../config.php');
// require_once($CFG->dirroot.'/local/powerschool/classes/configurerpaiement.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new powereduc_url('/local/powerschool/configurationmini.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('configurationminini', 'local_powerschool'));
$PAGE->set_heading(get_string('configurationminini', 'local_powerschool'));

$PAGE->navbar->add(get_string('statistique', 'local_powerschool'),  new powereduc_url('/local/powerschool/statistique.php'));
$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new configurerpaiement();



// if ($mform->is_cancelled()) {

//     redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

// } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


// $recordtoinsert = new stdClass();

// $recordtoinsert = $fromform;

//     // var_dump($fromform);
//     // die;
   
//        $DB->insert_record('filierecycletranc', $recordtoinsert);
//        redirect($CFG->wwwroot . '/local/powerschool/configurerpaiement.php', 'Enregistrement effectué');
//        exit;

// }

// if($_GET['id']) {

//     $mform->supp_configpaie($_GET['id']);
//     redirect($CFG->wwwroot . '/local/powerschool/configurerpaiement.php', 'Information Bien supprimée');
        
// }


// $sql="SELECT conf.id as idconf,libellefiliere,libelletranche,libellecycle,somme,datelimite FROM
//       {filierecycletranc} as conf,{filiere} as f,{tranche} as t,{cycle} as cy WHERE
//       conf.idfiliere=f.id AND conf.idtranc=t.id AND conf.idcycle=cy.id ";
// $configurer = $DB->get_records_sql($sql);

$templatecontext = (object)[
    // 'configurer' => array_values($configurer),
    'configedit' => new powereduc_url('/local/powerschool/configurerpaiementedit.php'),
    'configsupp'=> new powereduc_url('/local/powerschool/configurerpaiement.php'),
    'affecterprof' => new powereduc_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new powereduc_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new powereduc_url('/local/powerschool/coursspecialite.php'),
    'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
];

// $menumini = (object)[
//     'affecterprof' => new powereduc_url('/local/powerschool/affecterprof.php'),
//     'configurerpaie' => new powereduc_url('/local/powerschool/configurerpaiement.php'),
//     'semestre' => new powereduc_url('/local/powerschool/semestre.php'),
// ];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);
// $mform->display();


echo $OUTPUT->render_from_template('local_powerschool/configurationmini', $templatecontext);


echo $OUTPUT->footer();