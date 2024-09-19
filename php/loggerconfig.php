<?php
require_once "../vendor/autoload.php";

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

if(!file_exists("../logs/warnings.txt")){
    $handle = fopen("../logs/warnings.txt","c");
    fclose($handle);
}
if(!file_exists("../logs/info.txt")){
    $handle = fopen("../logs/info.txt","c");
    fclose($handle);
}

$warlog = new Logger('warlog');
$infolog = new Logger('infolog');

$warlog->pushHandler(new StreamHandler('../logs/warnings.txt'));
$infolog->pushHandler(new StreamHandler('../logs/info.txt'));
?>    