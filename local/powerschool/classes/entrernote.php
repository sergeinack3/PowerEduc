<?php
require_once(__DIR__ . '/../../../config.php');

$notes=$_POST['noteaj'];
$notescc=$_POST['notecc'];

foreach ($notes as $userId => $note) {
            // var_dump($note,$userId);
            // Enregistrer la note dans la base de données ou effectuer toute autre opération nécessaire
            // Utilisez $userId comme identifiant de l'étudiant et $note comme note soumise
            // $data = $userId . ": " . $note . "\n";
            // var_dump($data,"idaff=".$_GET['id']); 

            //select la ligne correspondant dans la liste de note
                if(!empty($note)){
                    $ligneliste=$DB->get_records("listenote",array("idaffecterprof"=>$_GET['id'],"idetudiant"=>$userId));
                    foreach ($ligneliste as $key => $value) {
                        # code...
                    }
                    // var_dump($value->id);die;
                    $noteetu=new stdClass();
                    $noteetu->id=$value->id;
                    $noteetu->idaffecterprof=$_GET['id'];
                    $noteetu->idbulletin=$_GET['idbu'];
                    $noteetu->idetudiant=$userId;
                    $noteetu->note3=$note;
                    $DB->update_record("listenote", $noteetu);
                    
                }
                
            }
            //cc
foreach ($notescc as $userId => $note) {
            // var_dump($note,$userId);
            // Enregistrer la note dans la base de données ou effectuer toute autre opération nécessaire
            // Utilisez $userId comme identifiant de l'étudiant et $note comme note soumise
            // $data = $userId . ": " . $note . "\n";
            // var_dump($data,"idaff=".$_GET['id']); 

            //select la ligne correspondant dans la liste de note
                if(!empty($note)){
                    $ligneliste=$DB->get_records("listenote",array("idaffecterprof"=>$_GET['id'],"idetudiant"=>$userId));
                    foreach ($ligneliste as $key => $value) {
                        # code...
                    }
                    // var_dump($value->id);die;
                    $noteetu=new stdClass();
                    $noteetu->id=$value->id;
                    $noteetu->idaffecterprof=$_GET['id'];
                    $noteetu->idbulletin=$_GET['idbu'];
                    $noteetu->idetudiant=$userId;
                    $noteetu->note2=$note;
                    $DB->update_record("listenote", $noteetu);
                    
                }
                
            }
            redirect($CFG->wwwroot . '/local/powerschool/note.php', 'les notes ont été bien enregistrées');
            // die;
            // die;
            
?>