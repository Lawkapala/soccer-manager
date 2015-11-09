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

$app->match('/admin/eventos', function(Request $request) use ($app) {
    $data = array('name'=>'');

    //get all images saved
    $basePath = __DIR__.'/../web/img/events/';
    $img_choices = array();

    foreach(glob($basePath.'*.png') as $img_file) {
        $fullName = substr($img_file, strlen($basePath));
        $name = substr($fullName,0,-4);

        $img_choices[$fullName] = $name;
    }

    //create form
    $form = $app['form.factory']->createBuilder('form',$data)
        ->add(
            'name', 'text',
            array('label' => 'Nombre')
        )
        ->add(
            'image', 'choice',
            array(
                'choices' => $img_choices,
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Selecciona imagen',
                'required' => false
            )
        )
        ->getForm();

    $form->handleRequest($request);

    //handle form request
    if ($form->isValid() && $form->isSubmitted()) {
        $data = $form->getData();

        $fields = array();

        if (isset($data['name']) && !empty($data['name'])) {
            $fields['name'] = $data['name'];
        }

        if (isset($data['image']) && !empty($data['image'])) {
            $fields['img_event'] = $data['image'];
        }

        $app['db']->insert('event', $fields);

        return $app->redirect($app['url_generator']->generate('eventos'));

    }

    //get all events saved in DB
    $events = $app['db']->fetchAll('SELECT * FROM event');

    return $app['twig']
        ->render('admin/event.html.twig',
            array(
                'events'            =>  $events,
                'availableImages'   =>  $img_choices,
                'form'              =>  $form->createView()
            )
        );
})
->bind('eventos')
;

$app->match('/admin/jornadas/form', function(Request $request) use ($app) {
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
            $app['db']->insert('matchday', array('name'=>$data['name']));

            return $app->redirect($app['url_generator']->generate('jornadas'));
        }
    }

    // get all positions saved in DB
    $matchdays = $app['db']->fetchAll('SELECT * FROM matchday');


    return $app['twig']->render('admin/matchdays.html.twig', array('matchdays'=>$matchdays,'form'=>$form->createView()));
})
->bind('jornadas')
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

$app->match('/admin/jugadores/form', function(Request $request) use ($app) {
    //get positions to select in form
    $positions = $app['db']->fetchAll('SELECT * FROM player_position');
    $pos_choice = function() use ($positions) {
        if (count($positions) == 0)
            return array();

        $pos = array();
        foreach($positions as $position) {
            $pos[$position['id']] = $position['name'];
        }
        return $pos;
    };

    //get teams to select in form
    $teams = $app['db']->fetchAll('SELECT * FROM team');
    $team_choice = function() use ($teams) {
        if (count($teams) == 0)
            return array();

        $t = array();
        foreach($teams as $team) {
            $t[$team['id']] = $team['name'];
        }
        return $t;
    };

    //create form
    $form = $app['form.factory']->createBuilder('form')
        ->add(
            'name', 'text',
            array('label' => 'Nombre')
        )
        ->add(
            'alias', 'text',
            array(
                'label' => 'Alias',
                'required' => false
            )
        )
        ->add(
            'position', 'choice',
            array(
                'label' => 'Posición',
                'choices' => $pos_choice()
            )
        )
        ->add(
            'number', 'text',
            array(
                'label' => 'Dorsal',
                'required' => false
            )
        )
        ->add(
            'team', 'choice',
            array(
                'label' => 'Equipo',
                'choices' => $team_choice()
            )
        )
        ->getForm();

    $form->handleRequest($request);

    //handle form request
    if ($form->isValid() && $form->isSubmitted()) {
        $data = $form->getData();

        echo "<pre>";print_r($data);echo "</pre>";

        $fields = array();

        if (isset($data['name']) && !empty($data['name'])) {
            $fields['name'] = $data['name'];
        }

        if (isset($data['alias']) && !empty($data['alias'])) {
            $fields['alias'] = $data['alias'];
        }

        if (isset($data['position']) && !empty($data['position'])) {
            $fields['position_id'] = $data['position'];
        }

        if (isset($data['number']) && !empty($data['number'])) {
            $fields['num_player'] = $data['number'];
        }

        if (isset($data['team']) && !empty($data['team'])) {
            $fields['team_id'] = $data['team'];
        }

        $app['db']->insert('player', $fields);

        $app->redirect($app['url_generator']->generate('jugadores'));
    }

    //get all players saved in DB
    $players = $app['db']->fetchAll('SELECT * FROM player');

    return $app['twig']
        ->render('admin/players.html.twig',
            array(
                'players'            =>  $players,
                'form'              =>  $form->createView()
            )
        );
})
->bind('jugadores')
;

$app->match('/admin/equipos/form', function(Request $request) use ($app) {
    //get all images saved
    $basePath = __DIR__.'/../web/img/teams/';
    $img_choices = array();

    foreach(glob($basePath.'*.png') as $img_file) {
        $fullName = substr($img_file, strlen($basePath));
        $name = substr($fullName,0,-4);

        $img_choices[$fullName] = $name;
    }

    //create form
    $form = $app['form.factory']->createBuilder('form')
        ->add(
            'name', 'text',
            array('label' => 'Nombre')
        )
        ->add(
            'image', 'choice',
            array(
                'choices' => $img_choices,
                'expanded' => false,
                'multiple' => false,
                'required' => false,
                'data'=> 'default.png'
            )
        )
        ->add(
            'webTeam', 'choice',
            array(
                'label' => 'Equipo de la web',
                'choices' => array(0=>'No', 1=>'Si'),
                'expanded' => true,
                'data'=> 0
            )
        )
        ->getForm();

    $form->handleRequest($request);

    //handle form request
    if ($form->isValid() && $form->isSubmitted()) {
        $data = $form->getData();

        $fields = array();

        if (isset($data['name']) && !empty($data['name'])) {
            $fields['name'] = $data['name'];
        }

        if (isset($data['image']) && !empty($data['image'])) {
            $fields['shield_name'] = $data['image'];
        }

        if (isset($data['webTeam']) && !empty($data['webTeam'])) {
            $fields['user_team'] = $data['webTeam'];
        }

        $app['db']->insert('team', $fields);

        return $app->redirect($app['url_generator']->generate('equipos'));

    }

    //get all events saved in DB
    $teams = $app['db']->fetchAll('SELECT * FROM team');

    return $app['twig']
        ->render('admin/teams.html.twig',
            array(
                'teams'            =>  $teams,
                'availableImages'   =>  $img_choices,
                'form'              =>  $form->createView()
            )
        );
})
    ->bind('equipos')
;

// error controller
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        var_dump(array($e->getMessage(),$code));
//        return;
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
