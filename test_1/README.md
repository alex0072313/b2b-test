# Задание 1

Имеется база со следующими таблицами:

```
CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) DEFAULT NULL,
    `gender` INT(11) NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
    `birth_date` INT(11) NOT NULL COMMENT 'Дата в unixtime.',
    PRIMARY KEY (`id`)
);

CREATE TABLE `phone_numbers` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `phone` VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
```

Напишите запрос, возвращающий имя и число указанных телефонных номеров девушек в возрасте от 18 до 22 лет.

Оптимизируйте таблицы и запрос при необходимости.

## Решение

```
SELECT `users`.`name` AS `name`, 
COUNT(`phone_numbers`.`id`) AS `total_phones`, 
FROM `users` 
INNER JOIN `phone_numbers` ON `phone_numbers`.`user_id` = `users`.`id` 
WHERE `users`.`gender` = 2 
AND TIMESTAMPDIFF(YEAR, FROM_UNIXTIME(`users`.`birth_date`), NOW()) BETWEEN 18 AND 22
GROUP BY `users`.`id`
```

## Оптимизация таблицы

users.gender - TINYINT, phone_numbers.phone - длина 10

```
CREATE TABLE `users` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) DEFAULT NULL,
    `gender` TINYINT NOT NULL,
    `birth_date` INT(11) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `phone_numbers` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `phone` VARCHAR(10) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
```

### Добавим индексы (при условии что данные в таблицах обновляются редко)

```
CREATE INDEX users_birth_date ON users (birth_date);
CREATE INDEX users_gender ON users (gender);
CREATE INDEX phone_numbers_user_id ON phone_numbers (user_id);
```
