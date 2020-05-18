<?php
require('connect.php');

// подгружаем данные из бд
global $pdo;
$sql = 'SELECT * FROM news';
$request = $pdo->prepare($sql);
$request->execute();
$data = $request->fetchAll();
// выведем данные на страницу
for( $i = 0; $i < count($data); $i++ ){
    echo '<div>
    <p>id_news:' . $data[$i]["id_news"]. '</p>
    <p>item:</p>'. $data[$i]["item"].'
    </div>';
}
echo "<h1>Решение:</h1>";

//Запросы
$request1 = '%Сложный вопрос%; DROP TABLE news WHERE id_news=1';
$request2 = '2 OR 1=1';
$sql1 = 'select * from news WHERE item LIKE :param;';
$sql2 = 'select * from news WHERE id_news=:param';
//Вызываем функцию для проверки sql-инъекций
echo testSqlInj($sql1, $request1) . '<br>';
echo testSqlInj($sql2, $request2);
function testSqlInj(string $sql, string $param)
{
    try {
        global $pdo;
        $request = $pdo->prepare($sql);
        $params = [
            ':param' => $param,
        ];
        $request->execute($params);
        $datas = $request->fetchAll();
        if($datas)
            return true;
        else
            return 'SQL-инъекция не прошла.';
    }
    catch (Exception $e)
    {
        return $e->getMessage();
    }
}
