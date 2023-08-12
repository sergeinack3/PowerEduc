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

namespace local_powerschool;
use stdClass;
use moodleform;
use local_powerschool\campus;


require_once("$CFG->libdir/formslib.php");

class coursspecialite extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $campus = new campus();
        $cours = $specialite = $cycle =  array();
        $sql1 = "SELECT * FROM {course} ";
        $sql2 = "SELECT sp.id,libellespecialite FROM {specialite} sp,{filiere} f WHERE sp.idfiliere=f.id AND idcampus='".$_GET["idca"]."' ";

        $sql4="SELECT * FROM {campus} c ,{typecampus} t WHERE c.idtypecampus=t.id AND c.id='".$_GET["idca"]."'";
        
        
        $cours = $campus->select($sql1);
        $specialite = $campus->select($sql2);
        $campuss = $campus->select($sql4);
        foreach($campuss as $key => $ca)
        {}
        if($ca->libelletype=="universite")
        {
            $sql3 = "SELECT * FROM {cycle} ";
        }else{
            $sql3 = "SELECT * FROM {cycle} where libellecycle='standard'";

        }
        $cycle = $campus->select($sql3);

        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','coursspecialite', 'Cours & Specialite');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
    
        foreach ($cours as $key => $val)
        {
            $selectcours[$key] = $val->fullname;
        }
        foreach ($specialite as $key => $val)
        {
            $selectspecialte[$key] = $val->libellespecialite;
        }
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle." ( ".$val->nombreannee." ans )";
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idcourses', 'courses', $selectcours ); // Add elements to your form
        $mform->setType('idcourses', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcourses', '');        //Default value
        $mform->addRule('idcourses', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idcourses', 'cours');

        $mform->addElement('select', 'idspecialite', 'specialite', $selectspecialte ); // Add elements to your form
        $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la Specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'cycle');

        $mform->addElement('text', 'credit',"Credit ou Coef"); // Add elements to your form
        $mform->setType('credit', PARAM_INT);                   //Set type of element
        // $mform->setDefault('credit', 0);        //Default value
        $mform->addRule('credit', 'Entrer le credit', 'required');
        $mform->addHelpButton('credit', 'Credit');

        $mform->addElement('hidden', 'usermodified'); // Add elements to your form
        $mform->setType('usermodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('usermodified', $USER->id);        //Default value

        $mform->addElement('hidden', 'timecreated', 'date de creation'); // Add elements to your form
        $mform->setType('timecreated', PARAM_INT);                   //Set type of element
        $mform->setDefault('timecreated', time());        //Default value

        $mform->addElement('hidden', 'timemodified', 'date de modification'); // Add elements to your form
        $mform->setType('timemodified', PARAM_INT);                   //Set type of element
        $mform->setDefault('timemodified', time());        //Default value

        $mform->addElement('hidden', 'idcampus', 'date de modification'); // Add elements to your form
        $mform->setType('idcampus', PARAM_INT);                   //Set type of element
        $mform->setDefault('idcampus',$_GET["idca"]);        //Default value

       

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
    public function update_coursspecialite($id, $idcourse,$idspecialite,$idcycle ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idcourses = $idcourse ;
        $object->idspecialite = $idspecialite ;
        $object->idcycle = $idcycle;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('coursspecialite', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_coursspecialite(int $coursspecialiteid)
    {
        global $DB;
        return $DB->get_record('coursspecialite', ['id' => $coursspecialiteid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_coursspecialite(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('coursspecialite', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    
    public function verifcourspeciali($coursid,$cycle,$sp){

        global $DB;
        $true=$DB->get_records_sql('SELECT * FROM {coursspecialite} WHERE idcourses="'.$coursid.'" AND idcycle="'.$cycle.'" AND idspecialite="'.$sp.'"');
        if ($true) {
            return true;
    }
}
}