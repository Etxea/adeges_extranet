<?php

//FIXME esto lod ebería hacer el autoload
//include_once "../vendor/etxea/sabremw/lib/SabreMW.php";
use Etxea\SabreMW;

$comunidad = $app['controllers_factory'];
$comunidad->get('/', function () use ($app) {
    $comunidad = $app['db']->fetchAssoc('SELECT * FROM tcomunidades WHERE id = ?', array('112'));;
    //var_dump($comunidad);
    $datos_comunidad = $app['db']->fetchAssoc('SELECT * FROM tcomunidades WHERE id = ?', array('112'));;
    return $app['twig']->render('comunidad.html', array('comunidad'=>$comunidad));
})
->bind('comunidad')
;

$comunidad->get('/seguros/', function () use ($app) {
    
    $seguro = $app['db']->fetchAssoc('SELECT * FROM tseguros JOIN tcomunidades ON tcomunidades.idseguro = tseguros.id WHERE tcomunidades.id = ?', array('112'));;
    //var_dump($seguro);
    return $app['twig']->render('comunidad/seguros.html', array('seguro'=>$seguro));
})
->bind('comunidad_seguro')
;

$comunidad->match('/{id}/propietarios/json/', function ($id) use ($app) {
    $propietarios = $app['db']->fetchAll('SELECT * FROM tpropietarios WHERE idcomunidad = ?', array($id));
    return $app->json($propietarios);
})
->bind('comunidad_propietarios_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal

return $comunidad

?>
