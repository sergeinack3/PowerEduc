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

class inscription extends moodleform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER;
        $campus = new campus();
        $etudiant = $anneescolaire = $ecole = $specialite = $cycle =  array();
        $sql1 = "SELECT u.id as userid,firstname,lastname FROM {user} u,{role_assignments} ro WHERE u.id=userid AND roleid=5";
        $sql2 = "SELECT * FROM {anneescolaire} ";
        $sql3 = "SELECT * FROM {campus} ";
        $sql4 = "SELECT * FROM {specialite} ";
        $sql5 = "SELECT * FROM {cycle} ";

        $etudiant = $campus->select($sql1);
        $anneescolaire = $campus->select($sql2);
        $ecole = $campus->select($sql3);
        $specialite = $campus->select($sql4);
        $cycle = $campus->select($sql5);
        


        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','inscription', ' Informations sur l étudiant');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        
        $gender=["h"=>"Homme",
                 "f"=>"Femme"];
        
        foreach($gender as $key => $valgen)
        {
            $selectgender[$key]=$valgen;
        }
        // var_dump($key);die;
        foreach ($etudiant as $key => $val)
        {
            $selectetudiant[$key] = $val->firstname." ".$val->lastname;
        }
        foreach ($anneescolaire as $key => $val)
        {
            $selectannee[$key] = date('Y',$val->datedebut)." - ".date('Y',$val->datefin);

        }
        foreach ($ecole as $key => $val)
        {
            $selectcampus[$key] = $val->libellecampus;
        }
        foreach ($specialite as $key => $val)
        {
            $selectspecialite[$key] = $val->libellespecialite;
        }
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idetudiant', 'Etudiant', $selectetudiant ); // Add elements to your form
        $mform->setType('idetudiant', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idetudiant', '');        //Default value
        $mform->addRule('idetudiant', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idetudiant', 'cours');
        
        $mform->addElement('text', 'numeroinscription', 'Numero inscription' ); // Add elements to your form
        $mform->setType('numeroinscription', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('numeroinscription', '');        //Default value
        $mform->addRule('numeroinscription', 'numero inscription', 'required', null, 'client');
        $mform->addHelpButton('numeroinscription', 'NumeroInscription');

        $mform->addElement('select', 'idanneescolaire', 'Annee scolaire', $selectannee ); // Add elements to your form
        $mform->setType('idanneescolaire', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idanneescolaire', '');        //Default value
        $mform->addRule('idanneescolaire', 'Choix de l annee scolaire', 'required', null, 'client');
        $mform->addHelpButton('idanneescolaire', 'specialite');

        $mform->addElement('select', 'idcampus', 'Campus', $selectcampus ); // Add elements to your form
        $mform->setType('idcampus', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcampus', '');        //Default value
        $mform->addRule('idcampus', 'Choix du campus', 'required', null, 'client');
        $mform->addHelpButton('idcampus', 'specialite');

        $mform->addElement('select', 'idspecialite', 'Specialite', $selectspecialite ); // Add elements to your form
        $mform->setType('idspecialite', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idspecialite', '');        //Default value
        $mform->addRule('idspecialite', 'Choix de la specialite', 'required', null, 'client');
        $mform->addHelpButton('idspecialite', 'specialite');

        $mform->addElement('select', 'idcycle', 'cycle', $selectcycle ); // Add elements to your form
        $mform->setType('idcycle', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('idcycle', '');        //Default value
        $mform->addRule('idcycle', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('idcycle', 'specialite');
       
        $mform->addElement('select', 'gender', 'gender', $selectgender ); // Add elements to your form
        $mform->setType('gender', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('gender', '');        //Default value
        $mform->addRule('gender', 'Choix du gender', 'required', null, 'client');
        $mform->addHelpButton('gender', 'specialite');
       
        $mform->addElement('date_time_selector', 'date_naissance', 'Date de naissance', $selectcycle ); // Add elements to your form
        $mform->setType('date_naissance', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('date_naissance', '');        //Default value
        $mform->addRule('date_naissance', 'Choix du cycle', 'required', null, 'client');
        $mform->addHelpButton('date_naissance', 'specialite');

        //informations sur le parent
        $mform->addElement('header','parent', 'Informations sur le parents');


        $mform->addElement('text', 'nomsparent', 'Noms du Parent' ); // Add elements to your form
        $mform->setType('nomsparent', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('nomsparent', '');        //Default value
        $mform->addRule('nomsparent', 'Noms du Parent', 'required', null, 'client');
        $mform->addHelpButton('nomsparent', 'heure');

        $mform->addElement('text', 'telparent', 'Telephone parent' ); // Add elements to your form
        $mform->setType('telparent', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('telparent', '');        //Default value
        $mform->addRule('telparent', 'Telephone Parent', 'required', null, 'client');
        $mform->addHelpButton('telparent', 'Telephone');

        $mform->addElement('text', 'emailparent', 'Email Parent' ); // Add elements to your form
        $mform->setType('emailparent', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('emailparent', '');        //Default value
        $mform->addHelpButton('emailparent', 'Telephone');

        $mform->addElement('text', 'professionparent', 'Email Parent' ); // Add elements to your form
        $mform->setType('professionparent', PARAM_TEXT);                   //Set type of element
        $mform->setDefault('professionparent', '');        //Default value
        $mform->addHelpButton('professionparent', 'Telephone');

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
    public function update_inscription($id, $idetudiant, $idanneescolaire,$idcampus,$idspecialite,$idcycle,$nomsparent,$telparent,
    $emailparent,$professionparent ): bool
    {
        global $DB;
        global $USER;
        $object = new stdClass();
        $object->id = $id;
        $object->idetudiant = $idetudiant ;
        $object->idanneescolaire = $idanneescolaire ;
        $object->idcampus = $idcampus ;
        $object->idspecialite = $idspecialite ;
        $object->idcycle = $idcycle ;
        $object->nomsparent = $nomsparent ;
        $object->telparent = $telparent ;
        $object->emailparent = $emailparent;
        $object->professionparent = $professionparent;
        $object->usermodified = $USER->id;
        $object->timemodified = time();



        return $DB->update_record('inscription', $object);
    }


     /** retourne les informations de l'année pour id =anneeid.
     * @param int $anneeid l'id de l'année selectionné .
     */

    public function get_inscription(int $inscriptionid)
    {
        global $DB;
        return $DB->get_record('inscription', ['id' => $inscriptionid]);
    }



    /** pour supprimer une annéee scolaire
     * @param $id c'est l'id  de l'année à supprimer
     */
    public function supp_inscription(int $id)
    {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $suppcampus = $DB->delete_records('inscription', ['id'=> $id]);
        if ($suppcampus){
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    public function veri_insc($iduser){
        global $DB;
        $true=$DB->get_record("inscription", array("idetudiant"=>$iduser));
        // $true1=$DB->get_record("inscription", array("idspecialite"=>$specialite));
        if ($true) {
           return true;
        }
        // if ($true1) {
        //    return true;
        // }

    }
}