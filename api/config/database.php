<?php
$db_name='mysql:host=localhost;dbname=registro_livro';
$db_user_name='mrcl';
$db_user_pass='P67a31kEJI4eveGECAV15iJEbiriHI';

$conn=new PDO($db_name,$db_user_name,$db_user_pass);

function create_unique_id(){
    $charecters='P67a31kEJI4eveGECAV15iJEbiriHI';
    $charecters_length=strlen(($charecters));
    $random='';
    for ($i=0; $i<30;$i++){
        $random.=$charecters[mt_rand(0,$charecters_length-1)];
    }
    return $random;
}

?>
