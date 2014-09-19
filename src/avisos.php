<?php
$avisos = $app['controllers_factory'];
$avisos->get('/', function () use ($app) {
    //$avisos = $app['db']->fetchAssoc('SELECT * FROM  WHERE id = ?', array('112'));;
    
    return $app['twig']->render('avisos.html', array());
})
->bind('avisos');

$avisos->match('/{id}/json/', function ($id) use ($app) {
    $avisos = $app['db']->fetchAll('SELECT * FROM tavisos WHERE idcomunidad = ?', array($id));
    
    return $app->json($avisos);
})
->bind('avisos_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal

return $avisos

?>
