<?php

// Переменная которая хранит имя пользователя
$userName = $_POST['user_login'];

// Переменная которая хранит почту пользователя
$userEmail = $_POST['user_email'];

// Переменная которая хранит номер телефона польз.
$userPhone = $_POST['user_phone'];

// htmlspecialchars - преобразует спец.символы в html
$userName = htmlspecialchars($userName);
$userEmail = htmlspecialchars($userEmail);
$userPhone = htmlspecialchars($userPhone);

// urldecode - декодирует URL, если пользователь попытается добавить URL в форму
$userName = urldecode($userName);
$userEmail = urldecode($userEmail);
$userPhone = urldecode($userPhone);

// trim - удаляет пробелы в начале и в конце строки
$userName = trim($userName);
$userEmail = trim($userEmail);
$userPhone = trim($userPhone);

$plusWebEmail = 'filippovnikolay195@gmail.com';

echo 'Имя пользователя: ', $userName;
echo '<br>';
echo 'Почта пользователя: ', $userEmail;
echo '<br>';
echo 'Номер телефона пользователя: ', $userPhone;

// Условие, которое прверяет отправилась ли форма при помощи PHP на указанный адрес почты
if (mail($plusWebEmail, $userName, $userEmail, $userPhone)) {
    header('location: index.html');
} else {
    echo '<br> Ошибка!';
}

?>




