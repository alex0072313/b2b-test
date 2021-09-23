<?php

abstract class Model
{
    /**
     * @var id
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        $this->$name = $value;
    }

    /**
     * Получить из базы по id
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        return null;
    }

}
