<?php
//fichier de definittion des liens de configuration

if($hassiteconfig) {
    $ADMIN->add('root',new admin_category('powerschool', 'powerschool'));

    $ADMIN->add('powerschool',new admin_externalpage('index',get_string('reglages', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/reglages.php')));

    $ADMIN->add('powerschool',new admin_externalpage('index',get_string('accueilp', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/index.php')));

    $ADMIN->add('powerschool',new admin_externalpage('inscription',get_string('gestinscription', 'local_powerschool')
    ,new moodle_url ('/local/powerschool/inscription/inscription.php'))); 

}


