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

//Vista que muestra el HTML
$comunidad->get('/cargos/', function () use ($app) {
    return $app['twig']->render('comunidad/cargos.html');
})->bind('comunidad_cargos');
//Vista que muestra el JSON para el datagrid
$comunidad->match('/{id}/cargos/json/', function ($id) use ($app) {
    $cargos = $app['db']->fetchAll('SELECT * FROM tpasadas WHERE idcomunidad = ?', array($id));;
    return $app->json($cargos);
})
->bind('comunidad_cargos_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal


//Vista que muestra el HTML
$comunidad->get('/convocatorias/', function () use ($app) {
    return $app['twig']->render('comunidad/convocatorias.html');
})->bind('comunidad_convocatorias');
//Vista que muestra el JSON para el datagrid
$comunidad->match('/{id}/convocatorias/json/', function ($id) use ($app) {
    $convocatorias = $app['db']->fetchAll('SELECT * FROM tconvocatorias WHERE idcomunidad = ?', array($id));;
    return $app->json($convocatorias);
})
->bind('comunidad_convocatorias_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal


//Vista que muestra el HTML
$comunidad->get('/acuerdos/', function () use ($app) {
    return $app['twig']->render('comunidad/acuerdos.html');
})->bind('comunidad_acuerdos');
//Vista que muestra el JSON para el datagrid
$comunidad->match('/{id}/acuerdos/json/', function ($id) use ($app) {
    $acuerdos = $app['db']->fetchAll('SELECT * FROM tacuerdos WHERE idcomunidad = ?', array('112'));;
    return $app->json($acuerdos);
})
->bind('comunidad_acuerdos_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal


//Vista que muestra el HTML
$comunidad->get('/proveedores/', function () use ($app) {
    return $app['twig']->render('comunidad/proveedores.html');
})->bind('comunidad_proveedores');
//Vista que muestra el JSON para el datagrid
$comunidad->match('/{id}/proveedores/json/', function ($id) use ($app) {
    $proveedores = $app['db']->fetchAll('SELECT * from tproveedores JOIN tproveedorescomunidad ON tproveedorescomunidad.idproveedor = tproveedores.id WHERE tproveedorescomunidad.idcomunidad = ?', array($id));;
    return $app->json($proveedores);
})
->bind('comunidad_proveedores_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal




$comunidad->match('/{id}/propietarios/json/', function ($id) use ($app) {
    $propietarios = $app['db']->fetchAll('SELECT * FROM tpropietarios WHERE idcomunidad = ?', array($id));
    return $app->json($propietarios);
})
->bind('comunidad_propietarios_json')
->assert('id', '\d+'); //nos aseguramos que nos pasan un decimal

return $comunidad

?>
