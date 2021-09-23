<?php

interface IUser
{
    public function saveArticle(Article $article) : ?object;

    public function getArticles() : array;
}
