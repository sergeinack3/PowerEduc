<?php
   require_once(__DIR__ . '/../../../config.php');
   global $DB;
   if ($_POST["cycle"] && $_POST["specialite"]&&$_POST["salle"]) {
    $sql="SELECT c.fullname FROM {course} c,{groups} g WHERE c.id=g.courseid
          AND name IN (SELECT numerosalle FROM {salle} WHERE id='".$_POST["salle"]."')";

    $cours=$DB->get_records_sql($sql);
    // var_dump($cours);die;
    foreach ($cours as $key => $value1) {
      echo'<tr>
              <td>'.$value1->fullname.'</td>
            </tr>';
 }
   }


?>