<?php
//1 ЗАДАНИЕ
// считываем текст из файла
$text = file_get_contents('input.txt');
//ищем число в кавычках
$pattern = '/\'[0-9]+\'/';
$text = preg_replace_callback($pattern, function($items) {
    $temp = explode('\'', $items[0]);
    return '\'' . $temp[1] * 2 . '\'';
}, $text);
echo $text;
//выводим полученный текст в другой файл
$fp = fopen("output.txt", "w");
fwrite($fp, $text);
fclose($fp);