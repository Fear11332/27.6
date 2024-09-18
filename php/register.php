<?php
session_start();
require_once __DIR__ . "/dbclass.php";
ini_set('display_errors', 'on');

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $connect = new Dbclass('localhost', 'postgres', 'saw', '27.6');
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
        
        header("Location: index.php");
    } else {
        // Если пользователь существует, проверяем тип регистрации
        if ($row['auth_type'] === 'oauth') {
            // Пользователь зарегистрирован через OAuth
            $_SESSION['email'] = $_POST['email'];
            header('Location: login.php');
            exit();
        } else {
            // Пользователь зарегистрирован обычным способом
            $_SESSION['email'] = $_POST['email'];
            header('Location: login.php');
            exit();
        }
    }
}