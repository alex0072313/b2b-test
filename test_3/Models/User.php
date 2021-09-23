<?php

class User extends Model implements IUser
{
    /**
     * @var $name
     */
    protected $name;

    /**
     * Создать новую статью для пользователя
     * @param Article $article
     * @return object|null
     */
    public function saveArticle(Article $article): ?object
    {
        // Делаем запрос к базе...
        return null;
    }

    /**
     * Получить все статьи пользователя
     * @return array
     */
    public function getArticles(): array
    {
        // Делаем запрос к базе...
        return [];
    }
}
