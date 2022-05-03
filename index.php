<?php

// Подключение к phpMyAdmin
$connect = mysqli_connect("localhost", "root", "7415698523", "plusweb");
if($connect == true) {
    echo '<script>console.log("phpMyAdmin - подключён")</script>';
} else {
    echo '<script>console.log("Ошибка подключения к phpMyAdmin")</script>';
}

// Создание таблиц
$tables = [
    "CREATE TABLE users(
        idUser int(10) AUTO_INCREMENT,
        PRIMARY KEY (idUser),
        loginUser varchar(256) NOT NULL,
        emailUser varchar(256) NOT NULL
    )",

    "CREATE TABLE usersPhone(
        usersPhoneId int(10) AUTO_INCREMENT,
        PRIMARY KEY (usersPhoneId),
        phoneUser int(255) NOT NULL,

        idUser int(10),
        FOREIGN KEY (idUser) REFERENCES users (idUser)
    )"
];

function tables($table) {
    global $connect;
    if(mysqli_query($connect, $table) == true) {
        echo '<script>console.log("Таблица созданна")</script>';
    } else {
        echo '<script>console.log("Ошибка или такая таблица есть: '.mysqli_error($connect).'")</script>';
    }
}
foreach ($tables as $value) {
    echo tables($value);
}

// Данные с html 
$userName = $_POST['user_login'];
$userEmail = $_POST['user_email'];
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

if(!empty($userName) && !empty($userEmail) && !empty($userPhone)) {
    $plusWebEmail = 'filippovnikolay195@gmail.com';

    echo 'Имя пользователя: ', $userName.'<br>';
    echo 'Почта пользователя: ', $userEmail.'<br>';
    echo 'Номер телефона пользователя: ', $userPhone;

    // Условие, которое прверяет отправилась ли форма при помощи PHP на указанный адрес почты
    if (mail($plusWebEmail, $userName, $userEmail, $userPhone)) {
        header('location: index.html');
        echo '<p>Отправлено!</p>';
    } else {
        echo '<br> Ошибка!';
    }

    // Отправка данных в phpMyAdmin в таблицу users
    if(mysqli_query($connect, "INSERT INTO users(loginUser, emailUser) VALUES ('".$userName."', '".$userEmail."')")) {
        echo '<script>console.log("Данные отправлены - users")</script>';
    } else {
        echo '<script>console.log("Ошибка отправки данных - users")</script>';
    }

    // Отправка данных в phpMyAdmin в таблицу usersPhone
    if(mysqli_query($connect, "INSERT INTO usersPhone(phoneUser) VALUES ('".$userPhone."')")) {
        echo '<script>console.log("Данные отправлены - phoneUser")</script>';
    } else {
        echo '<script>console.log("Ошибка отправки данных - phoneUser")</script>';
    }
} else {
    echo '<p>Форма не заполнена!</p>';
}

?>




