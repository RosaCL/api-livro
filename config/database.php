<?php
define ('DB_HOST', 'localhost');
define ('DB_USER', 'mrcl');
define ('DB_PASS', 'P67a31kEJI4eveGECAV15iJEbiriHI');
define ('DB_NAME', 'registro_livro');

function getBDConnection(){
    $conect= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conect->connect_error){
        die("Connection failed:" . $conect->connect_error);
    }

    return $conect;
}

?>