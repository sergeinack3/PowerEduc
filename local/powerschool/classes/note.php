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

class note extends powereducform {

    //Add elements to form
    public function definition() {
        global $CFG;
        
        global $USER,$DB;
        $campus = new campus();
        $semestre = $anneescolaire = $ecole = $specialite = $cycle =  array();
        // $sql1 = "SELECT * FROM {courssemestre} cs,{affecterprof} af,{semestre} se WHERE se.id=cs.idsemestre AND af.idcourssemestre=cs.id AND idprof='".$USER->id."'";
        $sql1 = "SELECT * FROM {semestre}";
        $sql2 = "SELECT * FROM {anneescolaire} ";
        $sql3 = "SELECT * FROM {campus} ";
        // $sql4 = "SELECT sp.id as ids,libellespecialite FROM {specialite} sp,{affecterprof} af,{courssemestre} cs,{coursspecialite} csp WHERE csp.idspecialite=sp.id AND cs.idcoursspecialite=csp.id AND cs.id=af.idcourssemestre AND idprof='".$USER->id."'";
        $sql4 = "SELECT * FROM {specialite}";
        // $sql5 = "SELECT * FROM {cycle} cy,{affecterprof} af,{courssemestre} cs,{coursspecialite} csp WHERE cy.id=csp.idcycle AND cs.idcoursspecialite=csp.id AND cs.id=af.idcourssemestre AND idprof='".$USER->id."'";
        $sql5 = "SELECT * FROM {cycle} ";

        $semestre = $campus->select($sql1);
        $anneescolaire = $campus->select($sql2);
        $ecole = $campus->select($sql3);
        $specialite = $DB->get_recordset_sql($sql4);
        $cycle = $campus->select($sql5);
        


        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('header','inscription', ' Configuration de note');

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
    
        foreach ($semestre as $key => $val)

        {
            $selectetudiant[$key] = $val->libellesemestre;
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
            // $key=$val->ids;
            $selectspecialite[$key] = $val->libellespecialite;

            // var_dump($selectspecialite,$key);
        }
        // die;
        foreach ($cycle as $key => $val)
        {
            $selectcycle[$key] = $val->libellecycle;
        }
        // var_dump( $campus->selectcampus($sql)); 
        // die;
        $mform->addElement('select', 'idsemestre', 'Semestre', $selectetudiant ); // Add elements to your form
        $mform->setType('idsemestre', PARAM_TEXT);                   //Set type of element
        $mform->addRule('idsemestre', 'Choix du Cours', 'required', null, 'client');
        $mform->addHelpButton('idsemestre', 'cours');

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

        //informations sur le parent
      

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
    // public function update_inscription(int $id, string $idetudiant, string $idanneescolaire,string $idcampus,
    // string $idspecialite,string $idcycle, string $nomsparent,string $telparent,
    // string $emailparent,string $professionparent ): bool
    // {
    //     global $DB;
    //     global $USER;
    //     $object = new stdClass();
    //     $object->id = $id;
    //     $object->idetudiant = $idetudiant ;
    //     $object->idanneescolaire = $idanneescolaire ;
    //     $object->idcampus = $idcampus ;
    //     $object->idspecialite = $idspecialite ;
    //     $object->idcycle = $idcycle ;
    //     $object->nomsparent = $nomsparent ;
    //     $object->telparent = $telparent ;
    //     $object->emailparent = $emailparent;
    //     $object->professionparent = $professionparent;
    //     $object->usermodified = $USER->id;
    //     $object->timemodified = time();



    //     return $DB->update_record('inscription', $object);
    // }


    //  /** retourne les informations de l'année pour id =anneeid.
    //  * @param int $anneeid l'id de l'année selectionné .
    //  */

    // public function get_inscription(int $inscriptionid)
    // {
    //     global $DB;
    //     return $DB->get_record('inscription', ['id' => $inscriptionid]);
    // }



    // /** pour supprimer une annéee scolaire
    //  * @param $id c'est l'id  de l'année à supprimer
    //  */
    // public function supp_inscription(int $id)
    // {
    //     global $DB;
    //     $transaction = $DB->start_delegated_transaction();
    //     $suppcampus = $DB->delete_records('inscription', ['id'=> $id]);
    //     if ($suppcampus){
    //         $DB->commit_delegated_transaction($transaction);
    //     }

    //     return true;
    // }

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