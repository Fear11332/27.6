 document.addEventListener('DOMContentLoaded', function() {
            // Получаем элементы формы
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const loginEmail = document.getElementById('login_email');
            const loginPassword = document.getElementById('login_password');
            const registerEmail = document.getElementById('register_email');
            const registerPassword = document.getElementById('register_password');

            // Функция для очистки полей
            function clearFields() {
                loginEmail.value = '';
                loginPassword.value = '';
                registerEmail.value = '';
                registerPassword.value = '';
            }

            // Добавляем события для переключения форм
            document.getElementById('login-btn').addEventListener('click', function() {
                clearFields();
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
            });

            document.getElementById('register-btn').addEventListener('click', function() {
                clearFields();
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            });
        });