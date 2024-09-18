<?php
    require_once __DIR__ . "/dbclass.php";
    session_start();
    ini_set('display_errors','on');
    require_once "loggerconfig.php";

    $submitted_token = $_POST['CSRF'] ?? '';
    $session_token = $_SESSION['CSRF'] ?? '';
    if(!empty($_COOKIE['remember'])){
        $infolog->info("пользователь вошел с coockie");
        header('Location: index.php');
        exit();
    }
    if ($submitted_token === $session_token) {
            $connect = new Dbclass('localhost','postgres','saw','27.6');
            $pdo_connect = $connect->getConnect();
            if(!empty($_POST['email'] && !empty($_POST['password']))){  
                $sql = 'select email,password from users where email = :email';
                $stmt = $pdo_connect->prepare($sql);
                $stmt->execute(['email'=>$_POST['email']]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!empty($row)){
                    if(password_verify($_POST['password'],$row['password'])){
                        $_SESSION['email'] = $_POST['email'];
                        if(isset($_POST['remember']) && !isset($_COOKIE['remember'])){
                            $coockieHash = password_hash($_POST['password'],PASSWORD_DEFAULT);
                            setcookie('remember',$coockieHash,time()+3600);
                            $sql = 'update users set coockie = :coockie where email = :email';
                            $stmt = $pdo_connect->prepare($sql);
                            $stmt->execute(['coockie'=>$coockieHash,'email'=>$_POST['email']]);
                            $infolog->info("для пользователя с email ".$_POST['email']." были устновлены coockie");
                        }
                        $infolog->info("пользователь с email ".$_POST['email']." авторизован");
                        header('Location: index.php');
                        exit();
                    }else{
                        $warlog->warning("пользовталеь с email ".$_POST['email']." ввел неверный пароль");
                        header('Location: auth.php');
                        exit();
                    }
                }
                else{
                    $warlog->warning("пользователя с email ".$_POST['email']." нет в системе");
                    header('Location: auth.php');
                    exit();
                }
        }else{
            $warlog->warning("не были переданы emial или password");
            header('Location: auth.php');
            exit();
        }
    }
else{
    $warlog->warning("сработал CSRF-токен, пользователь переведен на страницу авторизации");
    header('Location: auth.php');
    exit();
}
    