<?php

function routes()
{
    return require "routes.php";
}

function exactMatchUriInArrayRoutes($uri, $routes)
{
    if(array_key_exists($uri, $routes)) {
        return [$uri => $routes[$uri]];
    }
    return [];
}

function regularExpressionMatchArrayRouter($uri, $routes)
{
    return array_filter($routes, function ($value) use ($uri){
        $regex = str_replace('/', '\/', ltrim($value, '/'));
        $pattern = '/^' . $regex . '$/';
        return preg_match($pattern, ltrim($uri, '/'));
    }, ARRAY_FILTER_USE_KEY);
}

function params($uri, $matcheUri)
{
    if(!empty($matcheUri)){
        $matcheToGetParams = array_keys($matcheUri)[0];

        return array_diff(
            $uri,
            explode('/', ltrim($matcheToGetParams, '/'))
        );
    }

    return [];
}

function paramsFormat($uri, $params)
{

    $paramsData = [];

    foreach ($params as $index => $param){
        $paramsData[$uri[$index - 1]] = $param;
    }

    return $paramsData;
}

function router()
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $routes = routes();

    $matcheUri = exactMatchUriInArrayRoutes($uri, $routes);

    $params = [];
    if(empty($matcheUri)) {

        $matcheUri = regularExpressionMatchArrayRouter($uri, $routes);
        $uri = explode('/', ltrim($uri, '/'));

        $params = params($uri, $matcheUri);
        $params = paramsFormat($uri, $params);

    }

    if(!empty($matcheUri)){
        return controller($matcheUri, $params);

    }

    throw new Exception("algo deu errado");
}