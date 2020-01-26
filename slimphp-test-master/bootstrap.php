<?php

// Load up the config and create our application.
$config = include_once 'config.php';
$container = new \Slim\Container($config['slim']);
$app = new \Slim\App($container);

// Register view component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(
        'templates', [
        'cache' => false
        ]
    );

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
};

// Register a PDO instance and set defaults
$container['db'] = function () use ($config) {
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['name']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
