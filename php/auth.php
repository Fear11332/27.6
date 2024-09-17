<?php
    session_start();
    require_once __DIR__."/dbclass.php";

    if (empty($_SESSION['CSRF'])) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }
    $CSRF = $_SESSION['CSRF'];
    $connect = new Dbclass('localhost','postgres','saw','27.6');
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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация и Регистрация</title>
    <link rel="stylesheet" href="/CSS/style.css"> <!-- Подключаем внешний CSS файл -->
</head>
<body>

<div class="container">
    <!-- Левая часть: Авторизация с поддержкой OAuth 2.0 -->
    <div class="left">
        <div class="form-container">
            <h2>Авторизация</h2>
            <form action="/php/login.php" method="POST">
                <input type="email" id="login_email" name="email" placeholder="Email" required>
                <input type="password" id="login_password" name="password" placeholder="Пароль" required>
                <input type="hidden" name="token" value="<?php echo $token;?>"> <br/>
                <input type="checkbox" name="remember" value="value1">
                запомнить меня
                <button type="submit">Войти</button>
            </form>
            <button class="oauth-btn">Войти через Google</button>
        </div>
    </div>

    <!-- Правая часть: Регистрация -->
    <div class="right">
        <div class="form-container">
            <h2>Регистрация</h2>
            <form action="/php/register.php" method="POST">
                <input type="email" id="register_email" name="email" placeholder="Email" required>
                <input type="password" id="register_password" name="password" placeholder="Пароль" required>
                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
