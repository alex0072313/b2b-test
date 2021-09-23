# Задание 4

Проведите рефакторинг, исправьте баги и продокументируйте в стиле PHPDoc код, приведённый ниже (таблица users здесь аналогична таблице users из задачи №1).

Примечание: код написан исключительно в тестовых целях, это не "жизненный пример" :)
```
function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
        $db = mysqli_connect("localhost", "root", "123123", "database");
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
        while($obj = $sql->fetch_object()){
            $data[$user_id] = $obj->name;
        }
        mysqli_close($db);
    }
    return $data;
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48

$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
```
Плюсом будет, если укажете, какие именно уязвимости присутствуют в исходном варианте (если таковые, на ваш взгляд, имеются), и приведёте примеры их проявления.

### Уязвимости и проблемы

<ol>
<li>Переменная $user_id передается как есть - возможно внедрение sql иньекции, лучше использовать подготовленный запрос</li>
<li>Соединение с бд открывается на каждой итерации цикла</li>
<li>В данном примере запрос происходит на каждой итерации, хотя это можно выполнить за 1 запрос</li>
<li>В select желательно указывать те поля, которые действительно нужны</li>
</ol>

## Решение

```
<?php

/**
 * Передаем строку с id пользователей через запятую (1,2,3,20,...)
 * @param string $user_ids
 * @return array
 */
function load_users_data($user_ids) {
    //Подготавливаем массив c id
    $user_ids = explode(',', preg_replace('/\s/', '', $user_ids));
    
    //Соединение с бд
    $db = new mysqli("db", "azur", "123456", "azur");

    //Формируем запрос
    $user_ids_cnt = count($user_ids);
    $in_values = str_repeat('?,', $user_ids_cnt - 1) . '?';

    $sql = $db->prepare("SELECT id, name FROM users WHERE id IN ({$in_values})");
    $sql->bind_param(str_repeat("i", $user_ids_cnt), ...$user_ids);
    $sql->execute();
    $sql_result = $sql->get_result();

    //Формируем ответ
    $data = [];
    while($row = $sql_result->fetch_assoc()){
        $data[$row['id']] = $row['name'];
    }

    //Закрываем соединение
    $db->close();

    return $data;
}

$data = load_users_data('1,2,3,4,5');

foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
```
