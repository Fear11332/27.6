<?php
session_start();
require_once __DIR__ . "/dbclass.php";
require_once __DIR__ . "/loggerconfig.php";
require_once __DIR__ . "/sqlqueryclass.php";

if(!empty($_COOKIE['remember'])){
        $infolog->info("пользователь вошел с coockie");
        header('Location: index.php');
        exit();
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
      // Проверяем, существует ли email в таблице пользователей
    $stmt = $pdo_connect->prepare(Query::selectAllInfoFromUsers());
    $stmt->execute(['email' => $_POST['email']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($row)) {
        // Если email не существует, регистрируем нового пользователя
        $_SESSION['email'] = $_POST['email'];
        $stmt = $pdo_connect->prepare(Query::insertUser());
        $stmt->execute([
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);
        
        // Получаем ID нового пользователя
        $stmt = $pdo_connect->prepare(Query::selectIdFromUsers());
        $stmt->execute(['email' => $_POST['email']]);
        $user_id = $stmt->fetchColumn();
        
        // Присваиваем роль новому пользователю
        $stmt = $pdo_connect->prepare(Query::insertSimpleUser());
        $stmt->execute(['user_id' => $user_id]);
        $infolog->info("пользователь с email ".$_POST['email']." зарегестрировался");
        header("Location: index.php");
        exit();
    } else {
        // Если пользователь существует, возвращаем его на страницу авторизации/регитсрации
        $warlog->warning("пользователь пытается войти под email ".$_POST['email']." который уже есть в системе");
        header('Location: auth.php');
        exit();
    }
}
$warlog->warning("пользователь не заполнил одно из полей регитсрации");