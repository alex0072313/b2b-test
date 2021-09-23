<?php

class Article extends Model implements IArticle
{
    /**
     * @var $title
     */
    public $title;

    /**
     * @var $text
     */
    public $text;

    /**
     * @var $userId
     */
    protected $userId;

    /**
     * Получить автора статьи
     * @return User
     */
    public function getUser(): User
    {
        return User::getById($this->userId);
    }

    /** Изменить автора статьи
     * @param int $newUserId - id нового пользователя, к которому привязываем статью
     * @return User|null
     */
    public function changeUserTo(int $newUserId): ?User
    {
        if($newUser = User::getById($newUserId)){
            $this->userId = $newUserId;
            // Делаем запрос к базе...
            return null;
        }

        return null;
    }
}
