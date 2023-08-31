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
use local_powerschool\note;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/note.php');
// require_once('tcpdf/tcpdf.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/message:managemessages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/salleele.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('sallele', 'local_powerschool'));
$PAGE->set_heading(get_string('sallele', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new moodle_url('/local/powerschool/configurationmini.php'));
$PAGE->navbar->add(get_string('sallele', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

// $mform=new note();









// $inscription =$tab = array();

//cours

//filiere
// $sql3="SELECT i.id, u.firstname, u.lastname, a.datedebut, a.datefin, c.libellecampus, c.villecampus, 
//     s.libellespecialite, s.abreviationspecialite , cy.libellecycle, cy.nombreannee,u.id as userid,numerosalle,capacitesalle
//     FROM {inscription} i, {anneescolaire} a, {user} u, {specialite} s, {campus} c, {cycle} cy,{salleele} saet,{salle} sa
//     WHERE i.idanneescolaire=a.id AND saet.idetudiant=u.id AND sa.id=saet.idsalle AND etudiantpresen=1 AND i.idspecialite=s.id AND i.idcampus=c.id AND i.idcycle =cy.id AND i.idcampus='".$_GET["idca"]."'";

$sql3="SELECT
s.libellespecialite,
cy.libellecycle,
GROUP_CONCAT(DISTINCT CONCAT(sa.numerosalle, ' - ', sa.capacitesalle) ORDER BY sa.numerosalle ASC SEPARATOR ', ') AS salles_occupees
FROM
{inscription} i
JOIN
{anneescolaire} a ON i.idanneescolaire = a.id
JOIN
{user} u ON i.idetudiant = u.id
JOIN
{specialite} s ON i.idspecialite = s.id
JOIN
{campus} c ON i.idcampus = c.id
JOIN
{cycle} cy ON i.idcycle = cy.id
JOIN
{salleele} saet ON u.id = saet.idetudiant
JOIN
{salle} sa ON saet.idsalle = sa.id
WHERE
etudiantpresen = 1 AND i.idcampus = '".$_GET["idca"]."'
GROUP BY
s.libellespecialite, cy.libellecycle
ORDER BY
s.libellespecialite ASC, cy.libellecycle ASC;
";
$salleocc=$DB->get_records_sql($sql3);
$sql4="SELECT
s.libellespecialite,
cy.libellecycle,
GROUP_CONCAT(DISTINCT CONCAT(sa.numerosalle, ' - ', sa.capacitesalle) ORDER BY sa.numerosalle ASC SEPARATOR ', ') AS salles_occupees
FROM
{inscription} i
JOIN
{anneescolaire} a ON i.idanneescolaire = a.id
JOIN
{user} u ON i.idetudiant = u.id
JOIN
{specialite} s ON i.idspecialite = s.id
JOIN
{campus} c ON i.idcampus = c.id
JOIN
{cycle} cy ON i.idcycle = cy.id
JOIN
{salleele} saet ON u.id = saet.idetudiant
JOIN
{salle} sa ON saet.idsalle = sa.id
WHERE
(etudiantpresen = 0 OR sa.id NOT IN (SELECT saaa.id FROM {salle} saaa, {salleele} saa WHERE saaa.id = saa.idsalle AND saa.etudiantpresen = 1 AND saaa.idcampus = '".$_GET["idca"]."'))
    AND i.idcampus = '".$_GET["idca"]."'
GROUP BY
s.libellespecialite, cy.libellecycle
ORDER BY
s.libellespecialite ASC, cy.libellecycle ASC;
";
$sallenonoc=$DB->get_records_sql($sql4);
// Remplacez 'valeur_idca' par la valeur de $_GET["idca"]
// var_dump($sallenonoc);die;

$sql="SELECT * FROM {filiere} WHERE idcampus='".$_GET["idca"]."'";
$sql1="SELECT * FROM {salle} WHERE idcampus='".$_GET["idca"]."'";
$sql2="SELECT * FROM {campus}";
$filiere=$DB->get_records_sql($sql);
$salle=$DB->get_records_sql($sql1);
$campus=$DB->get_records_sql($sql2);

$templatecontext = (object)[
    'filiere'=>array_values($filiere),
    'campus'=>array_values($campus),
    'salle'=>array_values($salle),
    'salleocc'=>array_values($salleocc),
    'ajoute'=> new moodle_url('/local/powerschool/inscription.php'),
    'affectercours'=> new moodle_url('/local/powerschool/inscription.php'),
    'ajou'=> new moodle_url('/local/powerschool/classes/entrernote.php'),
    'coursid'=> new moodle_url('/local/powerschool/entrernote.php'),
    'bulletinnote'=> new moodle_url('/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'salleeleretirer' => new moodle_url('/local/powerschool/salleeleretirer.php'),

 ];

 $menumini = (object)[
    'affecterprof' => new moodle_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new moodle_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new moodle_url('/local/powerschool/coursspecialite.php'),
    'tranche' => new moodle_url('/local/powerschool/tranche.php'),
    'salleele' => new moodle_url('/local/powerschool/salleele.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),
    'confinot' => new moodle_url('/local/powerschool/configurationnote.php'),
    'logo' => new moodle_url('/local/powerschool/logo.php'),
    'message' => new moodle_url('/local/powerschool/message.php'),


];

// $menu = (object)[
//     'annee' => new moodle_url('/local/powerschool/anneescolaire.php'),
//     'campus' => new moodle_url('/local/powerschool/campus.php'),
//     'semestre' => new moodle_url('/local/powerschool/semestre.php'),
//     'salle' => new moodle_url('/local/powerschool/salle.php'),
//     'seance' => new moodle_url('/local/powerschool/seance.php'),
//     'filiere' => new moodle_url('/local/powerschool/filiere.php'),
//     'cycle' => new moodle_url('/local/powerschool/cycle.php'),
//     'modepayement' => new moodle_url('/local/powerschool/modepayement.php'),
//     'matiere' => new moodle_url('/local/powerschool/matiere.php'),
//     'specialite' => new moodle_url('/local/powerschool/specialite.php'),
//     'inscription' => new moodle_url('/local/powerschool/inscription.php'),
//     'enseigner' => new moodle_url('/local/powerschool/enseigner.php'),
//     'paiement' => new moodle_url('/local/powerschool/paiement.php'),
//     'programme' => new moodle_url('/local/powerschool/programme.php'),
//     'notes' => new moodle_url('/local/powerschool/note.php'),

// ];


echo $OUTPUT->header();


// echo $OUTPUT->render_from_template('local_powerschool/navbar', $menu);
// $mform->display();

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/salleele', $templatecontext);


echo $OUTPUT->footer();