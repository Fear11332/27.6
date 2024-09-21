<?php
require_once dirname(__DIR__,1)."/vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

if(!is_dir(dirname(__DIR__,1)."/logs"))
    mkdir(dirname(__DIR__,1)."/logs",0777,true);

if(!file_exists(dirname(__DIR__,1)."/logs/warnings.txt")){
    $handle = fopen(dirname(__DIR__,1)."/logs/warnings.txt","c");
    fclose($handle);
}
if(!file_exists(dirname(__DIR__,1)."/logs/info.txt")){
    $handle = fopen(dirname(__DIR__,1)."/logs/info.txt","c");
    fclose($handle);
}

$warlog = new Logger('warlog');
$infolog = new Logger('infolog');

$warlog->pushHandler(new StreamHandler(dirname(__DIR__,1).'/logs/warnings.txt'));
$infolog->pushHandler(new StreamHandler(dirname(__DIR__,1).'/logs/info.txt'));
?>    