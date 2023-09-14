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

namespace local_powerschool;
use stdClass;
use powereducform;
use local_powerschool\campus;


require_once("$CFG->libdir/formslib.php");

class programme extends powereducform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB;
        $campus = new campus();
        $cours = $specialite = $cycle =  array();

        $tarspecialcat=array();
$camp=$DB->get_records("campus",array("id"=>$_GET["idca"]));
foreach ($camp as $key => $value) {
    # code...
}
$categ=$DB->get_records("course_categories",array("name"=>$value->libellecampus));
foreach ($categ as $key => $value1categ) {
    # code...
}
// $filiere = $DB->get_records('filiere', array("idcampus"=>$_GET["idca"]));

$catfill=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=2");
$catspecia=$DB->get_records_sql("SELECT * FROM {course_categories} WHERE depth=3");
foreach($catfill as $key => $valfil)
{
    $fff=explode("/",$valfil->path);
    $idca=array_search($value1categ->id,$fff);
  if($idca!==false)
  {
    foreach($catspecia as $key => $vallssp)
    {
        $sss=explode("/",$vallssp->path);
        $idfill=array_search($valfil->id,$sss);
        if($idfill!==false)
        {

            // var_dump($vallssp->name);
            array_push($tarspecialcat,$vallssp->name);
        }
    }
    
  }
}
$stringspecialitecat=implode("','",$tarspecialcat);
// die;

$sql8 = "SELECT s.id,libellespecialite,libellefiliere,abreviationspecialite FROM {filiere} f, {specialite} s WHERE s.idfiliere = f.id AND idcampus='".$_GET["idca"]."' AND libellespecialite IN ('$stringspecialitecat')";

// $specialites = $DB->get_records_sql($sql);
        
        $sql9="SELECT u.id,firstname,lastname FROM {user} u,{coursspecialite} cs,{courssemestre} css,{affecterprof} af,{specialite} s,{filiere} f
               WHERE cs.idspecialite=s.id AND css.idcoursspecialite=cs.id AND css.id=af.idcourssemestre AND s.idfiliere=f.id AND af.idprof=u.id AND f.idcampus='".$_GET["idca"]."'";
        $sql1 = "SELECT c.id,fullname FROM {course} c,{coursspecialite} cs,{specialite} s,{filiere} f WHERE c.id=cs.idcourses 
                 AND cs.idspecialite=s.id AND s.idfiliere=f.id AND idcampus='".$_GET["idca"]."'";
        $sql2 = "SELECT * FROM {semestre}";
        // $sql3 = "SELECT s.id,libellespecialite FROM {specialite} s,{filiere} f WHERE f.id=s.idfiliere AND idcampus='".$_GET["idca"]."'";
        $sql4 = "SELECT * FROM {cycle} WHERE idcampus='".$_GET["idca"]."'";
        $sql5 = "SELECT * FROM {anneescolaire} ";
        
        $sql6 = "SELECT * FROM {periode} ";

        $sql7 = "SELECT id,numerosalle FROM {salle} WHERE idcampus='".$_GET["idca"]."'";

        $cours = $campus->select($sql1);
        $semestre = $campus->select($sql2);
        $specialite = $campus->select($sql8);
        $cycle = $campus->select($sql4);
        $anneescoalire = $campus->select($sql5);
        $periode = $campus->select($sql6);
        $salle = $campus->select($sql7);
        $profession = $campus->select($sql9);
        


        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','programme', 'Programmation des cours');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
    
        foreach ($cours as $key => $val)
        {
            $selectcours[$key] = $val->fullname."($val->shortname)";
        }
        foreach ($semestre as $key => $val)
        {
            $selectsemestre[$key] = $val->libellesemestre;
        }
        foreach ($specialite as $key => $val)
        {
            $selectspecialite[$key] = $val->libellespecialite;
        }
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        foreach ($anneescoalire as $key => $val)
        {
            $selectanneescolaire[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);
        }

        foreach ($periode as $key => $val)
        {
            $selectperiode[$key] = $val->libelleperiode;
        }
        foreach ($salle as $key => $val)
        {
            $selectsalle[$key] = $val->numerosalle;
        }
        foreach ($profession as $key => $prof)
        {
            $selectprofession[$key] = $prof->firstname."-".$prof->lastname;
        }
        
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('hidden', 'idcampus'); // Add elements to your form
        $mform->setDefault('idcampus', $_GET["idca"]); // Add elements to your form

        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectanneescolaire ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l Annee', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'Anneescolaire');

        $mform->addElement('select', 'idcourses', 'Cours', $selectcours ); // Add elements to your form
        $mform->setType('idcourses', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcourses', '');        //Default value
        $mform->addRule('idcourses', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idcourses', 'cours');

        $mform->addElement('select', 'idsemestre', 'Semestre', $selectsemestre ); // Add elements to your form
        $mform->setType('idsemestre', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idsemestre', '');        //Default value
        $mform->addRule('idsemestre', 'Choix du Semestre', 'required', null, 'client');
        $mform->addHelpButton('idsemestre', 'semestre');

        $mform->addElement('select', 'idspecialite', 'Specialite', $selectspecialite ); // Add elements to your form
        $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du Semestre', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'cycle');
    
        $mform->addElement('select', 'idsalle', 'Salle', $selectsalle ); // Add elements to your form
        $mform->setType('idsalle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idsalle', '');        //Default value
        $mform->addRule('idsalle', 'Choix une salle', 'required', null, 'client');
        $mform->addHelpButton('idsalle', 'Salle');
    
        $mform->addElement('select', 'idprof', 'Profession', $selectprofession ); // Add elements to your form
        $mform->setType('idprof', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idprof', '');        //Default value
        $mform->addRule('idprof', 'Choix une salle', 'required', null, 'client');
        $mform->addHelpButton('idprof', 'Salle');

        $mform->addElement('date_selector', 'datecours', 'Date du Cours' ); // Add elements to your form
        // $mform->setType('datecours', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('datecours', '');        //Default value
        $mform->addRule('datecours', ' date de cours ', 'required', null, 'client');
        $mform->addHelpButton('datecours', 'datecours');

        $mform->addElement('text', 'heuredebutcours', 'Heure debut cours' ); // Add elements to your form
        $mform->setType('heuredebutcours', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('heuredebutcours', '');        //Default value
        $mform->addRule('heuredebutcours', ' Heure debut du cours', 'required', null, 'client');
        $mform->addHelpButton('heuredebutcours', 'heure');

        $mform->addElement('text', 'heurefincours', 'Heure Fin Cours' ); // Add elements to your form
        $mform->setType('heurefincours', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('heurefincours', '');        //Default value
        $mform->addRule('heurefincours', ' Heure fin du cours', 'required', null, 'client');
        $mform->addHelpButton('heurefincours', 'heure');
       
        $mform->addElement('text', 'nobresemaine', 'Nombre de Semaine' ); // Add elements to your form
        $mform->setType('nobresemaine', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('nobresemaine', '');        //Default value
        $mform->addHelpButton('nobresemaine', 'heure');

        // $periode = ['une seance', 'sur un mois', 'sur deux mois', 'sur toute'];

        // $mform->addElement('select', 'idperiode', 'periode', $selectperiode ); // Add elements to your form
        // $mform->setType('idperiode', PARAM_TEXT);                   //Set type of element
        // $mform->setDefault('idperiode', '');        //Default value
        // $mform->addRule('idperiode', ' Heure fin du cours', 'required', null, 'client');
        // $mform->addHelpButton('idperiode', 'heure');

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

       

        $this->add_action_buttons();

    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }

    

     /** Mise à jour de l'année academique 
     * @param int $id l'identifiant de l'année a à modifier
     * @param string $datedebut la date de debut de l'annee
     * @param string $datefin date de fin de l'annee 
     */
    public function update_programme($id,$idanneescolaire,$idcourses,$idsemestre,$idspecialite,$idcycle,$datecours,$heuredebutcours, $heurefincours )
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idanneescolaire = $idanneescolaire ;
        $object->idcourses = $idcourses ;
        $object->idsemestre = $idsemestre ;
        $object->idspecialite = $idspecialite ;
        $object->idcycle = $idcycle ;
        $object->datecours = $datecours ;
        $object->heuredebutcours = $heuredebutcours ;
        $object->heurefincours = $heurefincours;
        $object->usermodified = $USER->id;
        $object->timemodified = time();


        // var_dump($object->datecours );die;

    $DB->update_record('programme', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_programme(int $programmeid)
    {
        global $DB;

        // $sql = "SELECT * FROM {course} c, {semestre} s,{specialite} sp,{cycle} cy, {programme} p WHERE p.idcourses = c.id AND p.idsemestre =s.id AND p.idspecialite = sp.id
        // AND p.idcycle = cy.id   ";

        return $DB->get_record('programme', ['id' => $programmeid]);
        // return $DB->get_record_sql($sql);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_programme(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('programme', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }


    /**
     * Permet de classer un cours en fonction d'une date dans un semestre
     * @param $datecours c'est la date du cours choisir
     */
    public function definir_semestre (int $datecours,$id){
        global $DB;


        $sqlsemestre = "SELECT * FROM {semestre} WHERE id='".$id."' AND $datecours BETWEEN  datedebutsemestre AND datefinsemestre";

        // var_dump($sqlsemestre);

        $semestre = $DB->get_records_sql($sqlsemestre);
        
        // var_dump($semestre);
      if($semestre)
      {

          foreach ($semestre as $key => $val)
          {
              $idsemestre = $val->id;
  
          }
  
         return $idsemestre;
        }
        else
        {
          return null;
          ;

      }

    }


    /**
     * Permet d'ajouter un cours de maniere automatique dans le programme des cours
     * @param $periode qui reprensente la periode pendant laquel le cours va etre programmer
     * 
     */
    public function periode ($idperiode){
        global $DB;

        $sqlperiode = "SELECT duree FROM {periode} WHERE id=$idperiode";

        $periode = $DB ->get_records_sql($sqlperiode);

        return $periode;

    }
}