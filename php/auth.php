<?php   
    require_once 'authconfig.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация и Регистрация</title>
    <link rel="stylesheet" href="/CSS/style.css"> <!-- Подключаем внешний CSS файл -->
    <script src="/JS/auth_js.js"></script>
</head>
<body>

<div class="container">
    <!-- Левая часть: Авторизация с поддержкой OAuth 2.0 -->
    <div class="left" id="login-form">
        <div class="form-container">
            <h2>Авторизация</h2>
            <form action="login.php" method="POST">
                <input type="email" id="login_email" name="email" placeholder="Email" required>
                <input type="password" id="login_password" name="password" placeholder="Пароль" required>
                <input type="hidden" name="CSRF" value="<?php echo $CSRF;?>"> <br/>
                <input type="checkbox" name="remember" value="value1">запомнить меня
                <button type="submit">Войти</button>
                <a href="<?php echo $client->createAuthUrl();?>">
                    <button type="button" class="oauth-btn">Войти через Google</button>
                </a>
            </form>
        </div>
        <button id="register-btn">Перейти к регистрации</button>
    </div>

    <!-- Правая часть: Регистрация -->
    <div class="right" id="register-form" style="display: none;">
        <div class="form-container">
            <h2>Регистрация</h2>
            <form action="register.php" method="POST">
                <input type="email" id="register_email" name="email" placeholder="Email" required>
                <input type="password" id="register_password" name="password" placeholder="Пароль" required>
                <button type="submit">Зарегистрироваться</button>
            </form>
        </div>
        <button id="login-btn">Перейти к авторизации</button>
    </div>
</div>

</body>
</html>
