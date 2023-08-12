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
use moodleform;
use stdClass;


require_once("$CFG->libdir/formslib.php");

class filiere extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB;
        $mform = $this->_form; // Don't forget the underscore!

        $sql = "SELECT * FROM {campus} ";
        $camp = $DB->get_records_sql($sql);

        $mform->addElement('header','Filiere ', 'Filiere');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'libellefiliere', 'Libellé filiere'); // Add elements to your form
        $mform->setType('libellefiliere', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('libellefiliere', '');        //Default value
        $mform->addRule('libellefiliere', 'Libelle Filiere', 'required', null, 'client');
        $mform->addHelpButton('libellefiliere', 'filiere');

        $mform->addElement('text', 'abreviationfiliere', 'Abreviation filiere'); // Add elements to your form
        $mform->setType('abreviationfiliere', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('abreviationfiliere', '');        //Default value
        $mform->addRule('abreviationfiliere', 'abreviation Filiere', 'required', null, 'client');
        $mform->addHelpButton('abreviationfiliere', 'abreviation');
              
        foreach ($camp as $key => $val)
        {
            $selectcamp[$key] = $val->libellecampus;
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idcampus', 'Campus', $selectcamp ); // Add elements to your form
        $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcampus', '');        //Default value
        $mform->addRule('idcampus', 'Choix du Campus', 'required', null, 'client');
        $mform->addHelpButton('idcampus', 'campus');
        
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
    public function update_filiere(int $id, string $libellefiliere,string $abreviationfiliere,$idcampus): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->libellefiliere = $libellefiliere ;
        $object->abreviationfiliere = $abreviationfiliere ;
        $object->idcampus = $idcampus ;
        $object->usermodified = $USER->id;
        $object->timemodified = time();

        return $DB->update_record('filiere', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_filiere(int $filiereid)
    {
        global $DB;
        return $DB->get_record('filiere', ['id' => $filiereid]);
    }

    public function selectfiliere (string $sql)
    {
        global $DB;


        return $DB->get_records_sql($sql);
        

    }

    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_filiere(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppfiliere = $DB->delete_records('filiere', ['id'=> $id]);
        if ($suppfiliere){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
    
    public function verifiliere(String $filiere,$idcampus)
    {
        global $DB;
        $true=$DB->get_record("filiere",array("libellefiliere"=>$filiere,"idcampus"=>$idcampus));

        if ($true) {
           return true;
        }
    }
}