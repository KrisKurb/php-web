<?php

require('connect.php');

global $pdo;
// проверим есть ли такой пользователь если да, то проверить, что заявка была более часа назад
$sql = 'SELECT * FROM "one_people" WHERE email=:email';
$params = [
    ':email' => $_POST['email']
];
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data = $stmt->fetchObject();
if(!$data){
    $sql = 'INSERT INTO "one_people"(name, surname, patronymic, email, num, dat) 
            VALUES(
            :name, 
            :surname, 
            :patronymic, 
            :email, 
            :num, 
            timezone(\'GMT-03\', CURRENT_TIMESTAMP)) 
            RETURNING dat, admin';
    $params = [
        ':name' => $_POST['name'],
        ':surname' => $_POST['surname'],
        ':patronymic' => $_POST['patronymic'],
        ':email' => $_POST['email'],
        ':num' => $_POST['num']
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchObject();

    // Формируем массив для JSON ответа
    $result = array(
        'error' => false,
        'name' => $_POST["name"],
        'surname' => $_POST["surname"],
        'patronymic' => $_POST["patronymic"],
        'email' => $_POST["email"],
        'num' => $_POST["num"],
        'message' => 'С Вами свяжутся после ' .
            date('H:i:s', strtotime($data->dat) - strtotime('01:30:00')) .
            ' ' . date('d.m.Y', strtotime($data->dat))
    );
    // отправляем данные на почту
    mail(
        $data->admin,
        'Форма с сайта',
        $result['name'] . ' '
        . $result['surname'] . ' '
        . $result['patronymic'] . ', '
        . $result['email'] . ', '
        . $result['num']
    );
    // Переводим массив в JSON
    echo json_encode($result);
} elseif (strtotime(date('Y-m-d', strtotime($data->data_add))) <=
    strtotime(date('Y-m-d')) and
    strtotime(date('H:i:s', strtotime($data->dat)-strtotime('01:00:00'))) <=
    strtotime(date('Y-m-d H:i:s'))) {
    $sql = 'UPDATE "one_people" 
    SET name=:name, 
    surname=:surname, 
    patronymic=:patronymic, 
    num=:num, 
    dat=timezone(\'GMT-03\', CURRENT_TIMESTAMP) 
    WHERE email=:email RETURNING dat, admin';
    $params = [
        ':name' => $_POST['name'],
        ':surname' => $_POST['surname'],
        ':patronymic' => $_POST['patronymic'],
        ':email' => $_POST['email'],
        ':num' => $_POST['num'],
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchObject();
    // Формируем массив для JSON ответа
    $result = array(
        'error' => false,
        'name' => $_POST["name"],
        'surname' => $_POST["surname"],
        'patronymic' => $_POST["patronymic"],
        'email' => $_POST["email"],
        'num' => $_POST["num"],
        'message' => 'Ваши данные обновлены, с Вами свяжутся после ' .
            date('H:i:s', strtotime($data->dat) - strtotime('02:00:00')) .
            ' ' . date('d.m.Y', strtotime($data->dat))
    );
    // отправляем данные на почту дефолтную
    mail(
        '\'' . $data->admin . '\'',
        'Форма с сайта',
        $result['name'] . ' '
        . $result['surname'] . ' '
        . $result['patronymic'] . ', '
        . $result['email'] . ', '
        . $result['num']
    );
    // Переводим массив в JSON
    echo json_encode($result);
} else {
    $result = array(
        'error' => true,
        'message' => 'Вам будет доступна форма в ' .
            date('H:i:s', strtotime($data->dat) - strtotime('02:00:00')) .
            ' ' . date('d.m.Y', strtotime($data->dat))
    );
    // Переводим массив в JSON
    echo json_encode($result);
}