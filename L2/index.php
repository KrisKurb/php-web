<?php
// подключение к БД
require('connect.php');

// путь до нашего .xml файла
$path = 'school.xml';
try {
    // считываем весь файл в переменную xmlString и проверяем на соответствие формат .xml
    $temp = file_get_contents($path);
    if (file_exists($path)) {
        $xmlString = simplexml_load_file($path);
        if (!@simplexml_load_string($temp))
            throw new Exception('Файл не соответствует стандарту xml.');
    } else {
        throw new Exception('Не удалось открыть файл.');
    }
    
    // проходим по каждой строчке
    foreach ($xmlString as $xml) {
        global $pdo;
        // формируем запрос
        $sql = 'INSERT INTO class(id, numeral, letter, kolvo, profile) 
        VALUES(:id, :numeral, :letter, :kolvo, :profile)';
        // передаем наши параметры из xml
        $params = [
            ':id' => $xml->id,
            ':numeral' => $xml->numeral,
            ':letter' => $xml->letter,
            ':kolvo' => $xml->kolvo,
            ':profile' => $xml->profile
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    }
    echo 'Данные успешно добавлены!';
} catch (Exception $e) {
    echo $e->getMessage();
    die();
}