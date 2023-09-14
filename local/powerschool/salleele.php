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

$PAGE->set_url(new powereduc_url('/local/powerschool/salleele.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title(get_string('sallele', 'local_powerschool'));
$PAGE->set_heading(get_string('sallele', 'local_powerschool'));

$PAGE->navbar->add(get_string('configurationminini', 'local_powerschool'),  new powereduc_url('/local/powerschool/configurationmini.php'));
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
    'ajoute'=> new powereduc_url('/local/powerschool/inscription.php'),
    'affectercours'=> new powereduc_url('/local/powerschool/inscription.php'),
    'ajou'=> new powereduc_url('/local/powerschool/classes/entrernote.php'),
    'coursid'=> new powereduc_url('/local/powerschool/entrernote.php'),
    'bulletinnote'=> new powereduc_url('/local/powerschool/bulletinnote.php'),
    'root'=>$CFG->wwwroot,
    'salleele' => new powereduc_url('/local/powerschool/salleele.php'),
    'salleeleretirer' => new powereduc_url('/local/powerschool/salleeleretirer.php'),

 ];

 $menumini = (object)[
    'affecterprof' => new powereduc_url('/local/powerschool/affecterprof.php'),
    'configurerpaie' => new powereduc_url('/local/powerschool/configurerpaiement.php'),
    'coursspecialite' => new powereduc_url('/local/powerschool/coursspecialite.php'),
    'tranche' => new powereduc_url('/local/powerschool/tranche.php'),
    'salleele' => new powereduc_url('/local/powerschool/salleele.php'),
    'message' => new powereduc_url('/local/powerschool/message.php'),
    'confinot' => new powereduc_url('/local/powerschool/configurationnote.php'),
    'logo' => new powereduc_url('/local/powerschool/logo.php'),
    'message' => new powereduc_url('/local/powerschool/message.php'),


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

echo $OUTPUT->render_from_template('local_powerschool/navbarconfiguration', $menumini);

echo $OUTPUT->render_from_template('local_powerschool/salleele', $templatecontext);


echo $OUTPUT->footer();