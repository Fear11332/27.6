<?php
session_start();
ini_set('display_errors', 'on');
require_once __DIR__ ."/dbclass.php";

$connect = new Dbclass('localhost','postgres','saw','27.6');
$pdo_connect = $connect->getConnect();

// Запрос для получения роли пользователя
$query = "SELECT r.role_name 
          FROM users u 
          JOIN user_roles ur ON u.id = ur.user_id 
          JOIN roles r ON ur.role_id = r.id 
          WHERE u.email = :email";

// Подготовленный запрос
$stmt = $pdo_connect->prepare($query);
$stmt->execute(['email' => $_SESSION['email']]);

$role = $stmt->fetchColumn();

// Отображение кнопки в зависимости от роли
if ($role === 'oauth') {
    echo '<button type="button" id="action">Действие только для Админа</button>';
} else {
    echo '<button disabled>вы не админ</button>';
}
?>
