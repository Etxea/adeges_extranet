<?php
$informes = $app['controllers_factory'];
$informes->get('/', function () use ($app) {
    //$informes = $app['db']->fetchAssoc('SELECT * FROM  WHERE id = ?', array('112'));;
    
    return $app['twig']->render('informes.html', array('informes'=>$informes));
})
->bind('informes');

$informes->get('/actas/', function () use ($app) {
    //$informes = $app['db']->fetchAssoc('SELECT * FROM  WHERE id = ?', array('112'));;
    $informes = false;
    return $app['twig']->render('informes_actas.html', array('informes'=>$informes));
})
->bind('informes_actas');

$informes->get('/morosidades/', function () use ($app) {
    $informes = $app['db']->fetchAssoc('SELECT * FROM tmorosidades WHERE idcomunidad = ?', array('112'));;
    //var_dump($informes);
    return $app['twig']->render('informes_morosidades.html', array('informes'=>$informes));
})
->bind('informes_morosidades');


return $informes

?>
