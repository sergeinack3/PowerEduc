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
use local_powerschool\specialite;

require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot.'/local/powerschool/classes/specialite.php');

global $DB;
global $USER;

require_login();
$context = context_system::instance();
// require_capability('local/powerschool:managepages', $context);

$PAGE->set_url(new moodle_url('/local/powerschool/specialite.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Enregistrer une specialite');
$PAGE->set_heading('Enregistrer une specialite');

$PAGE->navbar->add('Administration du Site',  new moodle_url('/local/powerschool/index.php'));
$PAGE->navbar->add(get_string('specialite', 'local_powerschool'), $managementurl);
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');
// $PAGE->requires->js_call_amd('local_powerschool/confirmsupp');

$mform=new specialite();



if ($mform->is_cancelled()) {

    redirect($CFG->wwwroot . '/local/powerschool/index.php', 'annuler');

} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $fromform = $mform->get_data()) {


$recordtoinsert = new stdClass();

$recordtoinsert = $fromform;

$recordtoinsert->idfiliere=$_POST["idfiliere"];
// var_dump($recordtoinsert->idcampus);
// die;
      if(!$mform->verispecialite($_POST["libellespecialite"],$_POST["idfiliere"],1))
      {

          $DB->insert_record('specialite', $recordtoinsert);
          redirect($CFG->wwwroot . '/local/powerschool/specialite.php?idca='.$recordtoinsert->idcampus.'', 'Enregistrement effectué');
        //   \core\notification::add('Enregistrement effectué', \core\output\notification::NOTIFY_SUCCESS);
        //   exit;
        }else{
          \core\notification::add('Cette Specialite existe dans ce campus', \core\output\notification::NOTIFY_ERROR);

      }
}

if($_GET['id']) {

    $mform->supp_specialite($_GET['id']);
    redirect($CFG->wwwroot . '/local/powerschool/specialite.php', 'Information Bien supprimée');
        
}


$sql = "SELECT * FROM {filiere} f, {specialite} s WHERE s.idfiliere = f.id AND idcampus='".$_GET["idca"]."'";

$specialites = $DB->get_records_sql($sql);

// $specialite = $DB->get_records('specialite', null, 'id');

// var_dump($specialites);
// die;

$verif1=[];
$verif2=[];
$campus=$DB->get_records('campus');

// $campus=$DB->get_records("campus");
$sql_fil="SELECT * FROM {filiere} WHERE idcampus='".$_GET["idca"]."'";
$filiere=$DB->get_records_sql($sql_fil);
$vericam=$DB->get_records_sql("SELECT * FROM {campus} c,{typecampus} t
                                WHERE t.id=c.idtypecampus AND c.id='".$_GET["idca"]."'");    
            foreach($vericam as $key => $ver)
            {
                if ($ver->libelletype=="primaire") {
                    $table1='
                <input type="checkbox" class="toutpr">
                <tr>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="petite session">Petite session</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="grande session">Grande session</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="Sil">Sil</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="CP">CP</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="CE1">CE1</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="CE2">CE2</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="CM1">CM1</td>
                    <td><input type="checkbox" name="specia[]" class="checkboxItem" value="CM2">CM2</td>
                </tr>';
                } else if($ver->libelletype=="lycee" || $ver->libelletype=="college"){
                  $table2='
                  <input type="checkbox" class="toutly">
                    <tr>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="6">6</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="5">5</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="4 All">4 All</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="4 ESP">4 ESP</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="3 All">3 All</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="2nd A4ESP">2nd A4ESP</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="2nd A4All">2nd A4All</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="2nd C">2nd C</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="1 C">1 C</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="1 D">1 D</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="1er A4ESP">1er A4ESP</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="1er A4All">1er A4All</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="T C">T C</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="T D">T D</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="Ter A4ESP">Ter A4ESP</td>
                        <td><input type="checkbox" name="specia[]" class="checkboxItem" value="Ter A4All">Ter A4All</td>
              </tr>';
                }
                
            }   
            // var_dump($_GET["idca"],$verfi2);die;
$campuss=(object)[
    'campus'=>array_values($campus),
    'confpaie'=>new moodle_url('/local/powerschool/specialite.php'),
            ]; 
$templatecontext = (object)[
    'specialite' => array_values($specialites),
    'filiere' => array_values($filiere),
    // 'campus' => array_values($campus),
    'table2' => $table2,
    'table1' => $table1,
    // 'verif1' => array_values($verif1),
    // 'verif2' => array_values($verif2),
    'specialiteedit' => new moodle_url('/local/powerschool/specialiteedit.php'),
    'specialiteex' => new moodle_url('/local/powerschool/specialite.php'),
    'specialitesupp'=> new moodle_url('/local/powerschool/specialite.php'),
    'cycle' => new moodle_url('/local/powerschool/cycle.php'),
    'idca'=>$_GET["idca"],
    'root'=>$CFG->wwwroot,
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
echo $OUTPUT->render_from_template('local_powerschool/campustou', $campuss);
$mform->display();


echo $OUTPUT->render_from_template('local_powerschool/specialite', $templatecontext);


echo $OUTPUT->footer();