<?php

interface IArticle
{
    public function getUser() : User;

    public function changeUserTo(int $userId) : ?User;
}
