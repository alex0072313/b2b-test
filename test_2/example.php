<?php

$some_string = 'https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3';

/**
 * Функция получает строку url, сортирует и фильрует параметры в query
 *
 * @param string $url - строка url, обязательно
 * @param array $exclude_params - массив значений, по которым query параметры будут отфильтрованы
 * @return string
 */

function urlFormat(string $url, array $exclude_params = []) {
    $result = null;

    if($url_data = parse_url($url)){
        //parse query string
        parse_str($url_data['query'], $url_params);

        //filter
        if($exclude_params){
            $url_params = array_filter($url_params, function ($v) use ($exclude_params) {
                return !in_array($v, $exclude_params);
            });
        }

        //sort
        asort($url_params);

        //add url param (path)
        if(isset($url_data['path'])) $url_params['url'] = $url_data['path'];

        //build url
        $scheme = $url_data['scheme'] ?? '';
        $host = $url_data['host'] ?? '';
        $params = $url_params ? '/?'.http_build_query($url_params) : '';

        $result = "{$scheme}//{$host}{$params}";
    }

    return $result;
}

echo urlFormat($some_string, [3]);
