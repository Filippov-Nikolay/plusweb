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
        idUser INT AUTO_INCREMENT,
        PRIMARY KEY (idUser),
        loginUser TEXT NOT NULL,
        emailUser TEXT NOT NULL,
        phoneUser INT NOT NULL
    )",

    "CREATE TABLE usersMessage(
        usersMessageId INT AUTO_INCREMENT,
        PRIMARY KEY (usersMessageId),
        userTopic TEXT NOT NULL,
        userMessage TEXT,

        idUser INT,
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
$userSelect = $_POST['user_select'];
$userText = $_POST['user_text'];

// htmlspecialchars - преобразует спец.символы в html
$userName = htmlspecialchars($userName);
$userEmail = htmlspecialchars($userEmail);
$userPhone = htmlspecialchars($userPhone);
$userSelect = htmlspecialchars($userSelect);
$userText = htmlspecialchars($userText);

// urldecode - декодирует URL, если пользователь попытается добавить URL в форму
$userName = urldecode($userName);
$userEmail = urldecode($userEmail);
$userPhone = urldecode($userPhone);
$userSelect = urldecode($userSelect);
$userText = urldecode($userText);

// trim - удаляет пробелы в начале и в конце строки
$userName = trim($userName);
$userEmail = trim($userEmail);
$userPhone = trim($userPhone);
$userSelect = trim($userSelect);
$userText = trim($userText);

$userPhone = (int)$userPhone;

if(!empty($userName) && !empty($userEmail) && !empty($userPhone) && !empty($userSelect)) {
    if(empty($userText)) {
        $userText = $userSelect;
    }
    
    echo '<p>Имя пользователя: '.$userName.'</p>';
    echo '<p>Почта пользователя: '.$userEmail.'</p>';
    echo '<p>Номер телефона пользователя: '.$userPhone.'</p>';
    echo '<p>Тема пользователя: '.$userSelect.'</p>';
    echo '<p>Текст пользователя: '.$userText.'</p>';

    $to = 'filippovnikolay195@gmail.com';
    $headers = 'Content-type:plain/text; charset=utf-8';
    $subject = $userSelect;
    $message = 'Отправил: '.$userName.PHP_EOL.'Почта: '.$userEmail.PHP_EOL.'Номер телефона: '.$userPhone.PHP_EOL.'Сообщение: '.$userText;
    $send = mail($to, $subject, $message, $headers);

    if($send == true) {
        header('location: index.html');
        echo '<p>Отправлено!</p>';
    } else {
        echo '<p>Произошла ошибка! Сообщение не отправлено</p>';
    }

    // Отправка данных в phpMyAdmin в таблицу users
    if(mysqli_query($connect, "INSERT INTO users(loginUser, emailUser, phoneUser) 
    VALUES ('".$userName."', '".$userEmail."', '".$userPhone."')")) {
        echo '<script>console.log("Данные отправлены - users")</script>';
    } else {
        echo '<script>console.log("Ошибка отправки данных - users")</script>';
    }

    // Отправка данных в phpMyAdmin в таблицу usersPhone
    if(mysqli_query($connect, "INSERT INTO usersMessage(userTopic, userMessage) 
    VALUES ('".$userSelect."', '".$userText."')")) {
        echo '<script>console.log("Данные отправлены - usersMessage")</script>';
    } else {
        echo '<script>console.log("Ошибка отправки данных - usersMessage")</script>';
    }
} else {
    echo '<p>Форма не заполнена!</p>';
    exit();
}

?>

