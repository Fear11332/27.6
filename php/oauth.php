<?php
session_start();
// Подключение к базе данных
ini_set('display_errors', 'on');
require_once 'dbclass.php';
require_once 'oauthconfig.php';
require_once 'loggerconfig.php';
if(!empty($_COOKIE['remember'])){
        $infolog->info("пользователь вошел с coockie");
        header('Location: index.php');
        exit();
}
$db = new Dbclass('localhost','postgres','27.6');

$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
    // Установка токена для клиента
    $client->setAccessToken($token);

    // Запрос данных профиля пользователя
    $oauth2 = new Google\Service\Oauth2($client);
    $google_user_info = $oauth2->userinfo->get();

    // Получение email и id
    $email = $google_user_info->email;
    $oauth_id = $google_user_info->id;

// Шаг 2: Проверяем, есть ли пользователь в базе по email
$user_stmt = $db->getConnect()->prepare("SELECT id, email, password, auth_type FROM users WHERE email = :email");
$user_stmt->execute(['email' => $email]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Если пользователя нет, регистрируем его в базе данных с пустым паролем и типом авторизации 'oauth'
    $user_insert_stmt = $db->getConnect()->prepare("INSERT INTO users (email, password, auth_type) VALUES (:email, '', 'oauth') RETURNING id");
    $user_insert_stmt->execute(['email' => $email]);
    $user_id = $user_insert_stmt->fetch(PDO::FETCH_ASSOC)['id'];

    // Добавляем информацию в таблицу oauth_users
    $oauth_user_stmt = $db->getConnect()->prepare("INSERT INTO oauth_users (user_id, provider_id, oauth_id) VALUES (:user_id, :provider_id, :oauth_id)");
    $oauth_user_stmt->execute([
        'user_id' => $user_id,
        'provider_id' => 1, // ID провайдера (например, Google)
        'oauth_id' => $oauth_id
    ]);

    $sql = 'select id from users where email = :email';
            $stmt = $db->getConnect()->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $user_id = $stmt->fetchColumn();
            $sql = 'insert into user_roles (user_id, role_id) values(:user_id ,1)';
            $stmt = $db->getConnect()->prepare($sql);
            $stmt->execute(['user_id'=>$user_id]);
} else {
    // Если пользователь существует, проверяем его тип авторизации
    if ($user['auth_type'] !== 'oauth') {
        $warlog->warning("пользователь с email ".$email." уже существует");
        // Если это не OAuth-пользователь, можно вывести ошибку или объединить аккаунты
        header("Location: auth.php");
        exit();
    }
}

// Шаг 3: Авторизуем пользователя в системе (установка сессии, редирект и т.д.)
$_SESSION['email'] = $user['email'];
$infolog->info("пользователь с email ".$email." авторизован с помощью OAuth");
header("Location: index.php");
exit();
?>
