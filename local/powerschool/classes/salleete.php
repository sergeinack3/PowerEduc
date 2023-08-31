<?php

require_once(__DIR__ . '/../../../config.php');
global $DB;
$etudiantsidd=explode(",",$_POST["etudiantsid"]);
$idanneescolaires=$DB->get_records("anneescolaire");

$sqlverisalle="SELECT count(idetudiant) as countetu FROM {salleele} WHERE idsalle='".$_POST["salle"]."' AND etudiantpresen=1";
$sqlcapacitesalle="SELECT capacitesalle FROM {salle} WHERE id='".$_POST["salle"]."'";
$verisalle=$DB->get_records_sql($sqlverisalle);
$capacitesalle=$DB->get_records_sql($sqlcapacitesalle);
foreach($verisalle as $key => $valversal)
{}
foreach($capacitesalle as $key => $valcapa)
{}
if($valversal->countetu==$valcapa->capacitesalle)
{
    echo "Cette salle est pleine";
}else
{

    foreach($idanneescolaires as $key=> $idannee){}
    $salleete= new stdClass();

    if(!empty($_POST["salle"])&&!empty($_POST["etudiantsid"]))
    {
        for($i=0;$i<count($etudiantsidd);$i++)
        {
        $sql="SELECT * FROM {salleele} WHERE idetudiant='".$etudiantsidd[$i]."' AND idsalle='".$_POST["salle"]."' AND etudiantpresen=1";
        $versalle=$DB->get_records_sql($sql);
        //  var_dump($versall)
    if(!$versalle){
            $salleete->idetudiant=$etudiantsidd[$i];
            $salleete->idsalle=$_POST["salle"];
            $salleete->idanneescolaire=$idannee->id;
            $salleete->usermodified=$USER->id;
            $salleete->etudiantpresen=1;
            $salleete->timecreated=time();
            $salleete->timemodified=time();

            $DB->insert_record("salleele",$salleete);
            echo "Bien enregistré";
        }else
        {

        }
        }

    }
}
?>