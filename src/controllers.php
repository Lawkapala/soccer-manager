<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/**
 * FRONT CONTROLLERS
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array());
})
->bind('homepage')
;

$app->get('/jornada', function() use ($app) {
    return $app['twig']->render('matchday.html.twig', array());
})
->bind('jornada')
;

$app->get('/jornada/{id}', function() use ($app) {
    return $app['twig']->render('match.html.twig', array());
})
->bind('partido')
;

$app->get('/jornadas', function() use ($app) {
    return $app['twig']->render('matchdays.html.twig', array());
})
->bind('jornadas')
;

$app->get('/clasificacion', function() use ($app) {
    return $app['twig']->render('teamtable.html.twig', array());
})
->bind('clasificacion')
;

$app->get('/jugadores', function() use ($app) {
    return $app['twig']->render('players.html.twig', array());
})
->bind('jugadores')
;

$app->get('/jugadores/{id}', function() use ($app) {
    return $app['twig']->render('player.html.twig', array());
})
->bind('jugador')
;


/**
 * ADMIN CONTROLLERS
 */
$app->get('/admin', function() use ($app) {
    return $app['twig']->render('admin/index.html.twig', array());
})
->bind('admin')
;

$app->match('/admin/eventos/form', function(Request $request) use ($app) {
    $data = array('name'=>'');

    $form = $app['form.factory']->createBuilder('form',$data)
        ->add(
            'name', 'text',
            array('label' => 'Nombre')
        )
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid() && $form->isSubmitted()) {
        $data = $form->getData();

        if (isset($data['name']) && !empty($data['name'])) {
            $app['db']->insert('event', array('name'=>$data['name']));

            return $app->redirect($app['url_generator']->generate('eventos'));
        }
    }

    //get all events saved in DB
    $events = $app['db']->fetchAll('SELECT * FROM event');

echo "<pre>";print_r(__DIR__);echo "</pre>";
echo "<pre>";print_r(__DIR__);echo "</pre>";

    //get all images saved
    $img = array();
    $finfo = finfo_open();
    $basePath = __DIR__.'/../web/img/';
    foreach(glob(__DIR__.'/../web/img/*.png') as $img_file) {

        $info = finfo_file($finfo,$img_file);
//        echo "<pre>";print_r($img_file);echo "</pre>";
//        echo "<pre>";print_r($i);echo "</pre>";

        $name = substr($img_file, strlen($basePath));
        $i[] = array($img_file, $info, $name);


        $img[] = $img_file;
    }

    echo "<pre>";print_r($i);echo "</pre>";

    return $app['twig']->render('admin/event.html.twig', array('events'=>$events,'form'=>$form->createView(),'img'=>$img));
})
->bind('eventos')
;

$app->match('/admin/posiciones/form', function(Request $request) use ($app) {
    $data = array('name'=>'');

    $form = $app['form.factory']->createBuilder('form',$data)
        ->add(
            'name', 'text',
            array('label' => 'Nombre')
        )
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid() && $form->isSubmitted()) {
        $data = $form->getData();

        if (isset($data['name']) && !empty($data['name'])) {
            $app['db']->insert('player_position', array('name'=>$data['name']));

            return $app->redirect($app['url_generator']->generate('posiciones'));
        }
    }

    // get all positions saved in DB
    $positions = $app['db']->fetchAll('SELECT * FROM player_position');


    return $app['twig']->render('admin/position.html.twig', array('positions'=>$positions,'form'=>$form->createView()));
})
->bind('posiciones')
;

// error controller
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        var_dump(array($e->getMessage(),$code));
       // return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
