<?php
session_start();
require_once __DIR__ . "/dbclass.php";
ini_set('display_errors', 'on');
require_once __DIR__ . "/loggerconfig.php";

if(!empty($_COOKIE['remember'])){
        $infolog->info("пользователь вошел с coockie");
        header('Location: index.php');
        exit();
}

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $connect = new Dbclass('localhost', 'postgres', '27.6');
    $pdo_connect = $connect->getConnect();
    
    // Проверяем, существует ли email в таблице пользователей
    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo_connect->prepare($sql);
    $stmt->execute(['email' => $_POST['email']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($row)) {
        // Если email не существует, регистрируем нового пользователя
        $_SESSION['email'] = $_POST['email'];
        $sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
        $stmt = $pdo_connect->prepare($sql);
        $stmt->execute([
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ]);
        
        // Получаем ID нового пользователя
        $sql = 'SELECT id FROM users WHERE email = :email';
        $stmt = $pdo_connect->prepare($sql);
        $stmt->execute(['email' => $_POST['email']]);
        $user_id = $stmt->fetchColumn();
        
        // Присваиваем роль новому пользователю
        $sql = 'INSERT INTO user_roles (user_id, role_id) VALUES (:user_id, 2)';
        $stmt = $pdo_connect->prepare($sql);
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