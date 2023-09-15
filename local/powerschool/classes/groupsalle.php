<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cours"] && $_POST["salle"]) {
    $sall=$DB->get_records("salle",array("id"=>$_POST["salle"]));
    foreach($sall as $val)
    {}
    $tarsp=[
        "cours"=>$_POST["cours"],
        "salle"=>$val->numerosalle,
        "route"=>$_POST["route"],
        "campus"=>$_POST["campus"],
        "idsalle"=>$_POST["salle"],
    ];

    echo json_encode($tarsp);

   }


?>