<?php

date_default_timezone_set('Europe/Madrid');

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;

$app = new Application();
$app->register(new TwigServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new TranslationServiceProvider());

$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...
    $twig->addGlobal('imgPath', 'img/');
    $twig->addGlobal('eventImgPath', 'img/events/');
    $twig->addGlobal('teamImgPath', 'img/teams/');
    $twig->addGlobal('playerImgPath', 'img/players/');

    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
        return $app['request_stack']->getMasterRequest()->getBasepath().'/'.$asset;
    }));

    $twig->addFunction(new \Twig_SimpleFunction('getString', function ($value, $type) use ($app) {
        if ($type == 'position_id') {
            $toString = $app['db']->fetchAssoc('SELECT * FROM f7_player_position WHERE id = ?', array($value));
        } elseif ($type == 'team_id') {
            $toString = $app['db']->fetchAssoc('SELECT * FROM f7_team WHERE id = ?', array($value));
        }

        if (isset($toString)) {
            return $toString['name'];
        }

        return '-';
    }));

    return $twig;
}));

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(
        'driver'    => 'pdo_mysql',
        'host'      => 'localhost',
        'dbname'    => 'sx_fut7',
        'user'      => 'root',
        'password'  => '',
        'charset'   => 'utf8',
    ),
));

return $app;
