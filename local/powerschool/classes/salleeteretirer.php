<?php

require_once(__DIR__ . '/../../../config.php');
global $DB;
$etudiantsidd=explode(",",$_POST["etudiantsid"]);
$idanneescolaires=$DB->get_records("anneescolaire");

foreach($idanneescolaires as $key=> $idannee){}
$salleete= new stdClass();

if(!empty($_POST["salle"])&&!empty($_POST["etudiantsid"]))
{
    for($i=0;$i<count($etudiantsidd);$i++)
    {
     $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."'";
     $versalle=$DB->get_records_sql($sql);
    //  var_dump($versalle);die;
    foreach($versalle as $key => $idsalle){
        
    }
    $salleete->id=$idsalle->id;
    $salleete->idetudiant=$etudiantsidd[$i];
    $salleete->idsalle=$_POST["salle"];
    $salleete->idanneescolaire=$idannee->id;
    $salleete->usermodified=$USER->id;
    $salleete->etudiantpresen=0;
    $salleete->timecreated=time();
    $salleete->timemodified=time();
    
    $ff=$DB->update_record("salleele",$salleete);
    //  var_dump($ff);die;
}
    // }

}
?>