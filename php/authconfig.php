<?php
    session_start();
    require_once __DIR__."/dbclass.php";
    require_once  __DIR__ . "/oauthconfig.php";
    ini_set('display_errors', 'on');
    if (empty($_SESSION['CSRF'])) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }
    $CSRF = $_SESSION['CSRF'];
    $connect = new Dbclass('localhost','postgres','27.6');
    $pdo_connect = $connect->getConnect();
        if(!empty($_COOKIE['remember'])){
                $sql = 'select coockie from users where coockie = :coockie';
                $stmt = $pdo_connect->prepare($sql);
                $stmt->execute(['coockie'=>$_COOKIE['remember']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!empty($row)){
                    header('Location: index.php');
                    exit();
                }
            }
