<?php


use Slim\Routing\RouteCollectorProxy;

$app->group('/api',function(RouteCollectorProxy $group){
  $group->get('/productos','App\Controllers\ProductosController:getAll');
  $group->get('/productoid/{id}','App\Controllers\ProductosController:getById');
  $group->post('/productos','App\Controllers\ProductosController:insertProducto');
  $group->delete('/producto/{id}', 'App\Controllers\ProductosController:eliminarProducto');
  $group->put('/producto/{id}','App\Controllers\ProductosController:updateById');
  $group->post('/upload-file-producto','App\Controllers\ProductosController:uploadFileProducto');
});
