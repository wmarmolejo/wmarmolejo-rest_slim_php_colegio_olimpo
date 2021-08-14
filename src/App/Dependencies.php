<?php
use Psr\Container\ContainerInterface;

$container->set('db',function(ContainerInterface $c){
  $config_db = $c->get('db_settings');
  $host=$config_db->DB_HOST;
  $pass=$config_db->DB_PASS;
  $user=$config_db->DB_USER;
  $charset=$config_db->DB_CHAR;
  $name=$config_db->DB_NAME;

    $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $name, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;

});


$container->set('uploadFileProducto',function(ContainerInterface $c){
    $ruta=__DIR__.'/../../uploads';
    return $ruta;
});
