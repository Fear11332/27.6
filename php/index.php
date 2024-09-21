<?php
session_start();
require_once __DIR__ ."/dbclass.php";
require_once __DIR__ ."/sqlqueryclass.php";

if(empty($_SESSION['email'])){
    header("Location: auth.php");
    exit();
}

// Подготовленный запрос
$stmt = $pdo_connect->prepare(Query::getRoles());
$stmt->execute(['email' => $_SESSION['email']]);

$role = $stmt->fetchColumn();

// Отображение кнопки в зависимости от роли
if ($role === 'oauth') {
    echo '<img src="../images/meme.jpg" </img> <p>привет пользователь oauth</p>';
} else {
    echo '<p>привет пользователь</p>';
}
?>
