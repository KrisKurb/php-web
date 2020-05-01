<?php
// подключение к БД
require('connect.php');

// подгружаем данные из бд
global $pdo;
$sql = 'SELECT * FROM allnews';
$inquiry = $pdo->prepare($sql);
$inquiry->execute();
$data = $inquiry->fetchAll();
// регулярное выражени по которому будем искать нашу ссылку
$pattern = '/(http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=)((\d+)-(\d+))&(\d+)/';
for ($i=0;$i<count($data);$i++) {
    // проверяем, действительно ли в этой записи есть значние, удовлетворяющее нашему регулярному выражению
    if (preg_match($pattern, $data[$i]['text_news'])) {
        $data[$i]['text_news'] = preg_replace_callback($pattern, function ($texts) {
            preg_match('/((\d+)-(\d+))/', $texts[0], $text);
            return 'http://sozd.parlament.gov.ru/bill/' . $text[0];
        }, $data[$i]['text_news']);
                echo $data[$i]['text_news'];
        // обновим данные
        global $pdo;
        $sql = 'UPDATE allnews SET text_news=:text_news WHERE id=:id';
        $inquiry = $pdo->prepare($sql);
        $params = [
        ':id' => $data[$i]['id'],
        ':text_news' => $data[$i]['text_news']
        ];
        $inquiry->execute($params);
    }
}