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
