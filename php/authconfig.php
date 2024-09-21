<?php
    session_start();
    require_once __DIR__."/dbclass.php";
    require_once  __DIR__ . "/oauthconfig.php";
    require_once __DIR__ ."/sqlqueryclass.php";
    
    if (empty($_SESSION['CSRF'])) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }
    $CSRF = $_SESSION['CSRF']; 
        if(!empty($_COOKIE['remember'])){
                $stmt = $pdo_connect->prepare(Query::getCoockieSQL());
                $stmt->execute(['coockie'=>$_COOKIE['remember']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!empty($row)){
                    header('Location: index.php');
                    exit();
                }
            }
