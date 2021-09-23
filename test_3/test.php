<?php

$userId = 1;
$articleId = 12;

$user = User::getById($userId);
$article = Article::getById($articleId);

//Статьи пользователя
$articlesByUser = $user->getArticles();

//Автор статьи
$userArticle = $article->getUser();

//Сменить автора статьи
$article->changeUserTo($userId);

//Создать новую статью для пользователя
$newArticle = new Article();
$newArticle->title = 'Новая статья';
$newArticle->text = 'Какой то текст';

$newArticle = $user->saveArticle($newArticle);
