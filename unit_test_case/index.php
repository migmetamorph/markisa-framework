<?php

/*
 * 
 * UNIT TEST CASE 
 * 
 */
error_reporting(1);

include './AdapterPDO.php';
include './config.php';

$sql        = 'SELECT * FROM test';
$pushsql    = 'INSERT INTO test(section_one, section_two) VALUES("'.rand(9999, 999999).'", "'.rand(9999, 999999).'")';

$pdo   = new singleAdapterPDO($config);

if($pdo->push($pushsql)>0){
        echo 'Added new rows <br /><br />';
    }

$row   = $pdo->pop($sql);
/*
$a     = $pdo->connect();

$s     = $a->prepare($sql);
$s->execute();
$row   = $s->fetchAll();
*/
foreach($row as $a => $b){
        foreach($b as $e => $f){
            if(!is_int($e)){
                    echo $e.' -> '.$f.'<br />';
                }
        }
        echo '<br />';
    }
        
    ?>